## Star Coaster Fix Plan (Approved ✅)

### Current Progress: 6/6 ✅ **COMPLETE**

✅ **Step 1**: `public/images/Elodie/nuages.png` created

**Step 2: Fix duplicate bgImg declaration**  
- Edit `templates/coaster/index.html.twig`: Remove duplicate `const bgImg`, fix src path to `{{ asset('images/Elodie/nuages.png') }}`

**Step 3: Clean up drawBackground() function**  
- Ensure fallback gradient works if image fails

✅ **Step 4**: `assets/app.js` → Stimulus import disabled

**Step 5: Verify asset paths**  
- All images use `{{ asset('images/...') }}` (Symfony standard)

**Step 6: Test game**  
- `symfony serve` → `/coaster?page=jeu`  
- Check console: No errors, bg loads, rails RGB (Rouge/Orange/Violet), 3 difficulty levels

### Notes
- JS stays **inline in Twig** (no external coaster.js)
- Rails: 3 colors `[#ff4444, #ffaa00, #aa44ff]`, pentu = currentLevel * 0.1
- Post-completion: Run `attempt_completion`

