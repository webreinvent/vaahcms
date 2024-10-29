/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      "./index.html",
      "./**/*.{vue,js,ts,jsx,tsx,.css}",
      "!./node_modules/**",
  ],
    theme: {
        extend: {
            animation: {
                'duration-450ms': 'duration-450ms 450ms ease-in-out',
            },
            keyframes: {
                'duration-450ms': {
                    '0%, 100%': { opacity: 1 },
                    '50%': { opacity: 0.5 },
                },
            },
        },
    },
  plugins: [require('tailwindcss-primeui')],
}

