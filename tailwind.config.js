import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["anta", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        themes: true,
    },

    plugins: [forms, require("@tailwindcss/typography"), require("daisyui")],
};
