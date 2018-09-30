# Magic: The Gathering Deck - WordPress Plugin

Simple WordPress plugin to display Magic Cards from https://api.magicthegathering.io/ API. Application allows search and sort options, and can be used on any WordPress page or plugin

__To View:__ Visit preview on my testing site http://blog.chelsealee.net/magic-challenge/

__To Install:__ Download files, upload plugin to WordPress from plugin menu, and activate plugin. Use shortcode `[magic-cards]` to display application from any post or page.

__To Develop:__ Download files, run `npm install`; run `gulp` to build js files.

***



*To Do:*
- Expand search functionality to include search by type, etc.
- Sort data without making new API request
- Add more sort options
- Build out WP admin interface to allow admin to change display options
- Download vendor scripts/styles and load locally (instead of CDN)
- Update to use Webpack ?
- Much more ...