import "./css/tssf.css";
import moment from "moment";

// Declare globals that come from mainscript.html.twig
declare global {
  var supportedLanguages: string[];
  var dateLocales: Record<string, string>;
  var navigator: Navigator & {
    userLanguage?: string;
    browserLanguage?: string;
  };
}

/* From https://stackoverflow.com/a/52112155 */
const getLanguage = (): string => {
  /* Check for our local storage first */
  if (typeof Storage !== "undefined") {
    if (localStorage.language) {
      return localStorage.language;
    }
  }
  if (navigator.languages && navigator.languages.length) {
    return navigator.languages[0];
  } else {
    return (
      navigator.userLanguage ||
      navigator.language ||
      navigator.browserLanguage ||
      "en"
    );
  }
};

const getSupportedLanguage = (): string => {
  let detectedLanguage = getLanguage();

  if (supportedLanguages.includes(detectedLanguage)) {
    return detectedLanguage;
  }
  return "en";
};

const setLanguage = (newLang: string): void => {
  localStorage.language = newLang;
  lang = getSupportedLanguage();

  /* Update the display */
  display_todays_obedience();
};

let intervalId: ReturnType<typeof setInterval>;

let lang = getSupportedLanguage();

function display_todays_obedience(): void {
  const todays_date = moment();
  display_obedience(todays_date);
}

function display_obedience(momentDate: moment.Moment): void {
  /* Set the current language button to active and the rest to inactive */
  document.querySelectorAll(".langButtons").forEach((elem) => {
    elem.classList.remove("active");
  });
  const activeBtn = document.querySelector(".langButtons[lang='" + lang + "']");
  if (activeBtn) {
    activeBtn.classList.add("active");
  }

  /* Hide all the boilerplate for all languages */
  document.querySelectorAll<HTMLElement>(".translatedBoilerplate").forEach((elem) => {
    elem.style.display = "none";
  });

  /* Show the boilerplate for the current language */
  document
    .querySelectorAll<HTMLElement>(".translatedBoilerplate[lang='" + lang + "']")
    .forEach((elem) => {
      elem.style.display = "block";
    });

  /* Ensure all divs are hidden */
  document
    .querySelectorAll<HTMLElement>("#jsmessage, .principal, .collect, .day, .feast")
    .forEach((elem) => {
      elem.style.display = "none";
    });

  /* Work out day of month */
  momentDate.locale("en-au"); /* Set to English for the dayofmonth/week stuff */
  let dayofmonth = momentDate.format("D");
  let monthofyear = momentDate.format("M");

  let principalnum = dayofmonth;

  const principalElem = document.querySelector<HTMLElement>(
    "#principal_" + lang + "_" + principalnum,
  );
  if (principalElem) principalElem.style.display = "block";

  const dayElem = document.querySelector<HTMLElement>("#day_" + lang + "_" + dayofmonth);
  if (dayElem) dayElem.style.display = "block";

  /* Work out day of week */
  let dayofweek = momentDate.format("d");
  const collectElem = document.querySelector<HTMLElement>("#collect_" + lang + "_" + dayofweek);
  if (collectElem) collectElem.style.display = "block";

  document
    .querySelectorAll<HTMLElement>("#feast_" + lang + "_" + monthofyear + "_" + dayofmonth)
    .forEach((elem) => {
      elem.style.display = "block";
    });
  momentDate.locale(dateLocales[lang]); /* Set to real locale to display date */
  const dateElem = document.querySelector<HTMLElement>("#date");
  if (dateElem) {
    dateElem.innerText = momentDate.format("LL");
  }
  update_display();
}

const ready = (callback: () => void): void => {
  if (document.readyState != "loading") callback();
  else document.addEventListener("DOMContentLoaded", callback);
};

ready(() => {
  display_todays_obedience();
});

function update_display(): void {
  /* Clear any current intervals before we start the next one */
  if (intervalId) clearInterval(intervalId);
  /* Refresh every 10 minutes */
  intervalId = setInterval(display_todays_obedience, 600000);
}

if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker
      .register("/sw.js")
      .then((registration) => {
        console.log("SW registered: ", registration);
      })
      .catch((registrationError) => {
        console.log("SW registration failed: ", registrationError);
      });
  });
}

// Expose setLanguage to global window for HTML buttons
(window as any).setLanguage = setLanguage;
