import "./bootstrap";
/* import { throttle } from "throttle-debounce";
import { renderGrid } from "@giphy/js-components";
import { GiphyFetch } from "@giphy/js-fetch-api";

// create a GiphyFetch with your api key
// apply for a new Web SDK key. Use a separate key for every platform (Android, iOS, Web)
const gf = new GiphyFetch("ieB2gpZOCPD8KeYIUeokSX3wPBY8xNXz");
// create a fetch gifs function that takes an offset
// this will allow the grid to paginate as the user scrolls
const fetchGifs = (offset) => gf.trending({ offset, limit: 5 });
// render a grid
const targetEl = document.getElementById("grid");
renderGrid({ width: 800, fetchGifs }, targetEl); */

//Source: https://github.com/saadeghi/theme-change
function themeToggle() {
    var toggleEl = document.querySelector("[data-toggle-theme]");
    (function (theme = localStorage.getItem("theme")) {
        if (localStorage.getItem("theme")) {
            document.documentElement.setAttribute("data-theme", theme);
            if (toggleEl) {
                [...document.querySelectorAll("[data-toggle-theme]")].forEach(
                    (el) => {
                        el.classList.add(
                            toggleEl.getAttribute("data-act-class")
                        );
                    }
                );
            }
        }
    })();
    if (toggleEl) {
        [...document.querySelectorAll("[data-toggle-theme]")].forEach((el) => {
            el.addEventListener("click", function () {
                var themesList = el.getAttribute("data-toggle-theme");
                if (themesList) {
                    var themesArray = themesList.split(",");
                    if (
                        document.documentElement.getAttribute("data-theme") ==
                        themesArray[0]
                    ) {
                        if (themesArray.length == 1) {
                            document.documentElement.removeAttribute(
                                "data-theme"
                            );
                            localStorage.removeItem("theme");
                        } else {
                            document.documentElement.setAttribute(
                                "data-theme",
                                themesArray[1]
                            );
                            localStorage.setItem("theme", themesArray[1]);
                        }
                    } else {
                        document.documentElement.setAttribute(
                            "data-theme",
                            themesArray[0]
                        );
                        localStorage.setItem("theme", themesArray[0]);
                    }
                }
                [...document.querySelectorAll("[data-toggle-theme]")].forEach(
                    (el) => {
                        el.classList.toggle(
                            this.getAttribute("data-act-class")
                        );
                    }
                );
            });
        });
    }
}
function themeBtn() {
    (function (theme = localStorage.getItem("theme")) {
        if (theme != undefined && theme != "") {
            if (
                localStorage.getItem("theme") &&
                localStorage.getItem("theme") != ""
            ) {
                document.documentElement.setAttribute("data-theme", theme);
                var btnEl = document.querySelector(
                    "[data-set-theme='" + theme.toString() + "']"
                );
                if (btnEl) {
                    [...document.querySelectorAll("[data-set-theme]")].forEach(
                        (el) => {
                            el.classList.remove(
                                el.getAttribute("data-act-class")
                            );
                        }
                    );
                    if (btnEl.getAttribute("data-act-class")) {
                        btnEl.classList.add(
                            btnEl.getAttribute("data-act-class")
                        );
                    }
                }
            } else {
                var btnEl = document.querySelector("[data-set-theme='']");
                if (btnEl.getAttribute("data-act-class")) {
                    btnEl.classList.add(btnEl.getAttribute("data-act-class"));
                }
            }
        }
    })();
    [...document.querySelectorAll("[data-set-theme]")].forEach((el) => {
        el.addEventListener("click", function () {
            document.documentElement.setAttribute(
                "data-theme",
                this.getAttribute("data-set-theme")
            );
            localStorage.setItem(
                "theme",
                document.documentElement.getAttribute("data-theme")
            );
            [...document.querySelectorAll("[data-set-theme]")].forEach((el) => {
                el.classList.remove(el.getAttribute("data-act-class"));
            });
            if (el.getAttribute("data-act-class")) {
                el.classList.add(el.getAttribute("data-act-class"));
            }
        });
    });
}
function themeSelect() {
    (function (theme = localStorage.getItem("theme")) {
        if (localStorage.getItem("theme")) {
            document.documentElement.setAttribute("data-theme", theme);
            var optionToggler = document.querySelector(
                "select[data-choose-theme] [value='" + theme.toString() + "']"
            );
            if (optionToggler) {
                [
                    ...document.querySelectorAll(
                        "select[data-choose-theme] [value='" +
                            theme.toString() +
                            "']"
                    ),
                ].forEach((el) => {
                    el.selected = true;
                });
            }
        }
    })();
    if (document.querySelector("select[data-choose-theme]")) {
        [...document.querySelectorAll("select[data-choose-theme]")].forEach(
            (el) => {
                el.addEventListener("change", function () {
                    document.documentElement.setAttribute(
                        "data-theme",
                        this.value
                    );
                    localStorage.setItem(
                        "theme",
                        document.documentElement.getAttribute("data-theme")
                    );
                    [
                        ...document.querySelectorAll(
                            "select[data-choose-theme] [value='" +
                                localStorage.getItem("theme") +
                                "']"
                        ),
                    ].forEach((el) => {
                        el.selected = true;
                    });
                });
            }
        );
    }
}

function themeChange(attach = true) {
    if (attach === true) {
        //changed this line so that it works with livewire's fast navigation
        document.addEventListener("livewire:navigated", function (event) {
            themeToggle();
            themeSelect();
            themeBtn();
        });
    } else {
        themeToggle();
        themeSelect();
        themeBtn();
    }
}
if (typeof exports != "undefined") {
    module.exports = { themeChange: themeChange };
} else {
    themeChange();
}
