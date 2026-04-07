// STAR COASTER LICORNE - VERSION 1° PROPRE & COMPLÈTE
// Rails spline, licorne wagon, HUD pixel, 3 niv, splinePoints, confettis victory

const canvas = document.getElementById('gameCanvas');

const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const path = "/assets/images/Elodie/"; // Correct Elodie subfolder
const assets = {
    licorne: new Image(), licorneDcd: new Image(), wagon: new Image(),
    coin: new Image(), star: new Image(),
    flagStart: new Image(), flagEnd: new Image(),
    hFull: path + "heart1.png", hEmpty: path + "heart3.png"
};

// CHARGEMENT ASSETS - Match Elodie files
assets.licorne.src = path + "licornee.png";
assets.licorneDcd.src = path + "licornedcd.png";
assets.wagon.src = path + "wagonjeu.jpg";
assets.coin.src = path + "coins.png";
assets.star.src = path + "star1.png";
assets.flagStart.src = path + "drapeaunoiretblancdroit.png";
assets.flagEnd.src = path + "drapeaunoiretblanc.png";

// AUDIO (optional)
// Sounds optional - comment out if missing
// const sounds = {
//     collect: new Audio('/assets/sounds/collect.mp3'),
//     jump: new Audio('/assets/sounds/jump.mp3')
// };
// Sounds & volume fully removed
// No more sounds.collect error

let posX = -200; 
let lives = 3; // 3 vies fixes
let coins = 0;
let stars = 0;
let currentLevel = 1;
let gameState = "WAITING"; 
const keys = {};

const player = { x: 150, y: 0, w: 75, h: 75, vY: 0, gravity: 0.5, jump: -18, onGround: false }; // Saut moins haut fluide

const levels = {
    1: { name: "Plage Calme", color: "#FF4500", speed: 4.5, finish: 4000, freq: 0.02, amp: 50, holes: [{s: 900, e: 1100}, {s: 2200, e: 2450}] },
    2: { name: "Forêt Dense", color: "#FFA500", speed: 5.5, finish: 4700, freq: 0.018, amp: 55, holes: [{s: 700, e: 950}, {s: 2100, e: 2400}] },
    3: { name: "Vol Magique", color: "#9400D3", speed: 6.5, finish: 5500, freq: 0.012, amp: 45, holes: [{s: 650, e: 900}, {s: 2200, e: 2500}, {s: 3900, e: 4250}] }
};

let levelItems = [];
function generateItems() {
    levelItems = [];
    const lvl = levels[currentLevel];
    // PLUS D'ITEMS : x += 150 au lieu de 250 (66% plus d'items)
    for (let x = 300; x < lvl.finish - 100; x += 150) {
        if (!lvl.holes.some(h => x > h.s - 30 && x < h.e + 30)) {
            // 70% coins, 30% étoiles (plus de pièces)
            levelItems.push({ 
                x: x + Math.random()*50, 
                yOffset: -80 - Math.random() * 80, 
                type: Math.random() > 0.3 ? 'coin' : 'star', 
                collected: false 
            });
        }
    }
}

window.addEventListener('keydown', e => {
    keys[e.code] = true;
    if (e.code === 'Space') {
        if (gameState === "WAITING") { 
            gameState = "PLAYING"; 
            generateItems(); 
        }
        else if (gameState === "PLAYING" && player.onGround) {
            player.vY = player.jump;
            player.onGround = false;
        }
        else if (gameState === "WIN") {
            nextLevel();
        }
    }
});
window.addEventListener('keyup', e => keys[e.code] = false);

function getRailY(x) {
    const lvl = levels[currentLevel];
    if (lvl.holes.some(h => x > h.s && x < h.e)) return null;
    let baseY = canvas.height * 0.7;
    return baseY + Math.sin(x * lvl.freq) * lvl.amp;
}

function update() {
    if (gameState !== "PLAYING") return;
    posX += levels[currentLevel].speed;
    player.vY += player.gravity;
    player.y += player.vY;

    // Collision Rail
    let cRY = getRailY(posX + player.x + player.w/2);
    if (cRY && player.y + player.h > cRY && player.vY > 0) {
        player.y = cRY - player.h; player.vY = 0; player.onGround = true;
    } else player.onGround = false;

    // Collect items
    levelItems.forEach(item => {
        if (!item.collected) {
            let itemX = item.x - posX;
            let railY = getRailY(item.x) || canvas.height * 0.7;
            let itemY = railY + item.yOffset;
            if (Math.abs(itemX - player.x) < 50 && Math.abs(itemY - player.y) < 80) {
                item.collected = true;
                if (item.type === 'coin') coins++; else stars++;
                // sounds.collect.play().catch(() => {});
                updateHUD();
            }
        }
    });

    // Chute
        if (player.y > canvas.height) {
        lives--;
        updateLivesDisplay(lives);
        updateHUD();
        if (lives <= 0) triggerGameOver();
        else { player.y = 0; player.vY = 0; posX -= 800; gameState = "WAITING"; }
    }

    if (posX + player.x > levels[currentLevel].finish) triggerWin();
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    const lvl = levels[currentLevel];

    // Pieds rails
    ctx.strokeStyle = "#D3D3D3"; ctx.lineWidth = 2;
    for (let i = 0; i < canvas.width + 100; i += 40) {
        let y = getRailY(posX + i);
        if (y) { ctx.beginPath(); ctx.moveTo(i, y); ctx.lineTo(i, canvas.height); ctx.stroke(); }
    }

    // Rail principal
    ctx.strokeStyle = lvl.color; ctx.lineWidth = 6; ctx.lineCap = 'round'; ctx.lineJoin = 'round'; ctx.beginPath();
    let drawing = false;
    for (let i = -100; i < canvas.width + 100; i += 2) {
        let y = getRailY(posX + i);
        if (y) {
            if (!drawing) { ctx.moveTo(i, y); drawing = true; }
            else ctx.lineTo(i, y);
        } else if (drawing) { ctx.stroke(); drawing = false; ctx.beginPath(); }
    }
    ctx.stroke();

    // Items
    levelItems.forEach(item => {
        if (!item.collected) {
            let itemX = item.x - posX;
            let railY = getRailY(item.x) || canvas.height * 0.7;
            let itemY = railY + item.yOffset;
            if (itemX > -50 && itemX < canvas.width + 50) {
                let img = item.type === 'coin' ? assets.coin : assets.star;
                if (img.complete) ctx.drawImage(img, itemX - 20, itemY - 20, 40, 40);
            }
        }
    });

    // Drapeaux
    let yS = getRailY(100); if (yS && (100-posX) > -100 && assets.flagStart.complete) ctx.drawImage(assets.flagStart, 100-posX, yS-90, 60, 90);
    let yE = getRailY(lvl.finish); if (yE && (lvl.finish-posX) < canvas.width+100 && assets.flagEnd.complete) ctx.drawImage(assets.flagEnd, lvl.finish-posX, yE-90, 70, 90);

    // Joueur
    if (assets.wagon.complete) ctx.drawImage(assets.wagon, player.x - 10, player.y + 35, 95, 55);
    let uImg = (lives <= 0 || gameState === "GAMEOVER") ? assets.licorneDcd : assets.licorne;
    if (uImg && uImg.complete) ctx.drawImage(uImg, player.x, player.y, player.w, player.h);

    // Waiting overlay
    if (gameState === "WAITING") {
        ctx.fillStyle = "rgba(0,0,0,0.7)"; ctx.fillRect(0,0,canvas.width, canvas.height);
        ctx.fillStyle = "white"; ctx.font = "bold 36px Arial"; ctx.textAlign = "center"; ctx.textBaseline = "middle";
        ctx.fillText(`NIVEAU ${currentLevel}`, canvas.width/2, canvas.height/2 - 40);
        ctx.fillText(lvl.name, canvas.width/2, canvas.height/2);
        ctx.font = "bold 24px Arial";
        ctx.fillText("ESPACE POUR JOUER", canvas.width/2, canvas.height/2 + 60);
    }

    update();
    requestAnimationFrame(draw);
}

function triggerWin() {
    gameState = "WIN";
    const overlay = document.getElementById('end-screen-EM');
    overlay.style.display = 'flex';
    const title = document.getElementById('stat-title-EM');
    title.textContent = currentLevel < 3 ? 'NIVEAU TERMINÉ ! ESPACE → suivant' : 'FÉLICITATIONS ! 🎉';
    document.getElementById('stat-stars-EM').textContent = stars;
}

function nextLevel() {
    if (currentLevel < 3) {
        currentLevel++;
        posX = -200;
        lives = 3;
        coins = 0;
        stars = 0;
        gameState = "WAITING";
        document.getElementById('end-screen-EM').style.display = 'none';
        updateHUD();
        generateItems();
    }
}

function triggerGameOver() {
    gameState = "GAMEOVER";
    const overlay = document.getElementById('end-screen-EM');
    overlay.style.display = 'flex';
    document.getElementById('stat-title-EM').textContent = 'GAME OVER licorne est tombée... ure';
    document.getElementById('stat-coins-EM').textContent = coins;
    document.getElementById('stat-stars-EM').textContent = stars;
    
    // LICORNE morte centrée
    const gameOverImg = document.createElement('img');
    gameOverImg.src = '../images/Elodie/licornedcd.png';
    gameOverImg.style.cssText = `
        position: absolute; top: 50%; left: 50%; 
        transform: translate(-50%, -50%); 
        width: 200px; height: auto; 
        filter: drop-shadow(0 0 20px rgba(255,0,0,0.5));
        z-index: 10;
    `;
    overlay.appendChild(gameOverImg);
}

function updateLivesDisplay(lives) {
    const container = document.getElementById('lives-container');
    if (container) {
        const hearts = container.querySelectorAll('.heart-EM');
        hearts.forEach((heart, index) => {
            if (index < lives) {
                heart.classList.remove('coeur-perdu');
            } else {
                heart.classList.add('coeur-perdu');
            }
        });
    }
}

function updateHUD() {
    document.getElementById('level-display').textContent = `NIVEAU ${currentLevel}`;
    document.getElementById('val-stars').textContent = stars;
    updateLivesDisplay(lives);
}

// Start when assets loaded
if (assets.licorne.complete) {
    updateHUD();
    generateItems();
    draw();
} else {
    assets.licorne.onload = () => {
        updateHUD();
        generateItems();
        draw();
    };
}

