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
                sans: ["Poppins", "sans-serif"],
            },
            fontWeight: {
                regular: 400, // Regular weight
                medium: 500, // Medium weight
                bold: 600, // Bold weight
            },
            fontStyle: {
                normal: "normal",
                italic: "italic",
                oblique: "oblique",
            },
        },
    },
    plugins: [],
};
