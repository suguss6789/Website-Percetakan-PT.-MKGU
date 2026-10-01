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
            // Lebar konten ikut membesar di monitor lebar (root font juga fluid, lihat app.css).
            maxWidth: { page: '84rem' },
            // Ukuran teks fluid: membesar/mengecil mulus mengikuti lebar layar (juga saat zoom).
            fontSize: {
                'fluid-hero': ['clamp(2.4rem, 1.2rem + 3.4vw, 4.75rem)', { lineHeight: '1.04' }],
                'fluid-h1': ['clamp(2.2rem, 1.3rem + 2.8vw, 4.25rem)', { lineHeight: '1.06' }],
                'fluid-h2': ['clamp(1.75rem, 1.15rem + 1.9vw, 3rem)', { lineHeight: '1.1' }],
                'fluid-h3': ['clamp(1.4rem, 1rem + 1.3vw, 2.4rem)', { lineHeight: '1.12' }],
                'fluid-lead': ['clamp(1.05rem, 0.95rem + 0.35vw, 1.3rem)', { lineHeight: '1.6' }],
            },
        },
    },
    plugins: [],
};
