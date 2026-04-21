# Image Paths Fix Plan

## Steps:

1. ✅ Create this TODO.md
2. 🔄 Edit public/assets/styles/app.css - Replace all broken CSS url() paths to '/assets/images/...'
3. 🔄 Clear Symfony cache: `bin/console cache:clear`
4. ✅ Test wheel page backgrounds (/wheel) and other pages (landing, equipe, fin)
5. ✅ attempt_completion

**Details:** Standardize ~11 broken relative paths (../images/, img/, ../assets/Axel/) to absolute /assets/images/... for consistency. Wheel template already correct.
