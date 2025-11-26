/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                pj: ["PlusJakartaSans", "sans-serif"],
            },
        },
    },
    plugins: [],
}
