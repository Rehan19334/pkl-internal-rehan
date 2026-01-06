# Plan to Fix Homepage Display with Bootstrap

## Information Gathered
- Current home.blade.php uses custom styles and some Bootstrap classes
- Layout includes hero, categories, promo banners, featured products
- Bootstrap is imported in app.css
- Navbar is separate in partials/navbar.blade.php
- Footer is in partials/footer.blade.php

## Plan
1. Update hero section to use Bootstrap grid and utilities
2. Improve categories section with proper Bootstrap cards and grid
3. Enhance promo banners with Bootstrap components
4. Fix featured products section with Bootstrap cards
5. Remove conflicting custom CSS and use Bootstrap utilities
6. Ensure full responsiveness across all sections

## Dependent Files
- resources/views/home.blade.php (main file to edit)
- resources/views/partials/navbar.blade.php (already Bootstrap)
- resources/views/partials/footer.blade.php (check if Bootstrap)

## Followup Steps
- Test responsiveness on different screen sizes
- Verify Bootstrap classes are properly applied
- Check for any remaining custom styles that conflict
