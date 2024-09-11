/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    darkMode: ["class", '[data-theme="dark"]'], // or 'media' or 'class'
    daisyui: {
        themes: [
            {
                light: {
                    primary: "#00bbb0",
                    "primary-content": "#000d0b",
                    secondary: "#31de00",
                    "secondary-content": "#011200",
                    accent: "#007200",
                    "accent-content": "#d1e3cf",
                    neutral: "#1a2121",
                    "neutral-content": "#cccdcd",
                    "base-100": "#ffffff",
                    "base-200": "#ded6de",
                    "base-300": "#bdb7bd",
                    "base-content": "#161516",
                    info: "#00cfff",
                    "info-content": "#001016",
                    success: "#00b390",
                    "success-content": "#000c07",
                    warning: "#e58100",
                    "warning-content": "#120600",
                    error: "#e41156",
                    "error-content": "#ffd8db",
                },
                dark: {
                    "color-scheme": "dark",
                    primary: "#38bdf8",
                    secondary: "#818CF8",
                    accent: "#F471B5",
                    neutral: "#1E293B",
                    "base-100": "#000000",
                    info: "#0CA5E9",
                    "info-content": "#000000",
                    success: "#2DD4BF",
                    warning: "#F4BF50",
                    error: "#FB7085",
                },
            },
        ],
    },
    plugins: [require("daisyui"), require("tailgrids/plugin")],
};
