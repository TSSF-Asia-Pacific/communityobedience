declare global {
  interface Window {
    _paq?: unknown[][];
  }
}

const paq = (window._paq = window._paq ?? []);
/* tracker methods like "setCustomDimension" should be called before "trackPageView" */
paq.push(["trackPageView"]);
paq.push(["enableLinkTracking"]);

const matomoBaseUrl = "//piwik.whiteitsolutions.com.au/";
paq.push(["setTrackerUrl", `${matomoBaseUrl}matomo.php`]);
paq.push(["setSiteId", "22"]);

const script = document.createElement("script");
script.type = "text/javascript";
script.async = true;
script.defer = true;
script.src = `${matomoBaseUrl}matomo.js`;
document.head.appendChild(script);

export {};
