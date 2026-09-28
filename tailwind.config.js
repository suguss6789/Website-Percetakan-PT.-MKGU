/** @type {import('tailwindcss').Config} */
export default {
    content: ['./resources/views/**/*.blade.php', './resources/js/**/*.js', './app/**/*.php'],
    theme: {
        extend: {
            colors: {
                brand: {
                    green: '#0AA84A',
                    'green-deep': '#067A35',
                    'green-ink': '#04552A',
                    yellow: '#F9D01A',
                    'yellow-soft': '#FDF1B3',
                    orange: '#F05A28',
                    'orange-deep': '#C9431A',
                },
                paper: { DEFAULT: '#FAF7F0', dark: '#F2EDE1' },
                ink: { DEFAULT: '#1B1F1A', muted: '#5C6259', soft: '#8A8F86' },
                line: '#E4DFD3',
            },
            fontFamily: {
                display: ['"Bricolage Grotesque Variable"', 'system-ui', 'sans-serif'],
                sans: ['"Plus Jakarta Sans Variable"', 'system-ui', 'sans-serif'],
                mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
            },
            borderRadius: { DEFAULT: '4px' },
            maxWidth: { page: '1200px' },
        },
    },
    plugins: [],
};
