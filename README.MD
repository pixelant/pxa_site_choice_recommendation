# Site choice recommendation

## What does it do?
Suggest localized version of site depends on user location and user language.
It will show bar on top of the page with possibility to choose site language. Select box options are sorted by priority calculated by checking user location and accept language.

## How to install it
Like a regular extension you need to do a few steps.
1. Composer install
    `composer require pixelant/pxa-site-choice-recommendation`
2. Go to extension manager to isntall extension.
3. Include TypoScript. There are two options to include:
    - *Site choice recommendation - default configuration required for extension to work*
    - *Site choice JS and CSS assets - will include Js and Css libs*

## Extension plugins
Extension has two plugins:
1. Choice bar extension - Loaded by ajax to propose user to change site version. Can't be added on a page.
2. Site choice recommendation splash page - Use as page content in order to show for user ALL available choices. Just select corresponding site choice configuration in order to show it's options.

## How to create site choice configuration
Create new record "Site Choice Configuration". It could be created in any storage folder.
"Site Choice Configuration" tabs:
Main "**General**" tab:
- *Name* - just whatever you want
- *Connect to sites* - choose **rootpages where bar should appear**
- *Max Items* - maximum items in select box in bar
- *Splash pages links* - splash page link for every root page. Each root page might have it's own splash page.

"**Choices**" tab include available site choices for bar and splash page. Each site choice require next configration fields:
-  *Title* - title of choice. **It's text area** because it could have **different versions(localizations)** of title.
You could specify different localization versions each in new row in a format "Title text|locale":
```text
Default title
Swedish title|sv_SE
Ukrainian title|uk_UA
```
- *Flag* - flag icon to show in select box and splash page
- *Select country* - select country. This field represents ISO code (for ex. "us" for USA). This code will be used when check if choice match by user IP. [ISO codes](https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes)
- *Select language* - select language from list. This field represents short ISO code (for ex. "en" for English). This code will be used for check by user language.
- *Link* - **if choice target to external url**
- *Language layer* - **if choice should lead to site langauge layer**. *Link* need to be empty if language layer is used.

## Expected results
After TypoScript is included and *Site Choice Configuration* is connected to root page, you should get bar with proposal of best matching country / region based on location.
**Note:** bar will remain invisible in case you already has visited website localization version that best match you location/language.

This product includes GeoLite2 data created by MaxMind, available from
<a href="https://www.maxmind.com">https://www.maxmind.com</a>.
