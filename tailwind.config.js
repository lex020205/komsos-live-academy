/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Warna custom dari desain Komsos Live Academy
        primary: '#032448',
        'primary-container': '#1f3a5f',
        'primary-fixed': '#d0e4ff',
        'primary-fixed-dim': '#9fcaff',
        'on-primary': '#ffffff',
        'on-primary-container': '#d0e4ff',
        'on-primary-fixed': '#001d34',
        'on-primary-fixed-variant': '#1f3a5f',
        
        secondary: '#7e5700',
        'secondary-container': '#fdc668',
        'secondary-fixed': '#ffddb7',
        'secondary-fixed-dim': '#fdc668',
        'on-secondary': '#ffffff',
        'on-secondary-container': '#281800',
        'on-secondary-fixed': '#281800',
        'on-secondary-fixed-variant': '#7e5700',
        
        tertiary: '#002b15',
        'tertiary-container': '#ceffc8',
        'tertiary-fixed': '#ceffc8',
        'tertiary-fixed-dim': '#b2e3ae',
        'on-tertiary': '#ffffff',
        'on-tertiary-container': '#002106',
        'on-tertiary-fixed': '#002106',
        'on-tertiary-fixed-variant': '#1c5225',
        
        error: '#ba1a1a',
        'error-container': '#ffdad6',
        'on-error': '#ffffff',
        'on-error-container': '#410002',
        
        background: '#fffbff',
        'on-background': '#1b1b1f',
        surface: '#fcf9f8',
        'surface-dim': '#dcd9d9',
        'surface-bright': '#fcf9f8',
        'surface-container-lowest': '#ffffff',
        'surface-container-low': '#f6f3f2',
        'surface-container': '#f0eded',
        'surface-container-high': '#eae7e7',
        'surface-container-highest': '#e5e2e1',
        'on-surface': '#1b1b1f',
        'on-surface-variant': '#44464f',
        
        outline: '#757780',
        'outline-variant': '#c5c6d0',
        'inverse-surface': '#303034',
        'inverse-on-surface': '#f2f0f4',
        'inverse-primary': '#9fcaff',
        'inverse-secondary': '#ffc947',
        
        shadow: '#000000',
        scrim: '#000000',
        
        'surface-tint': '#1f5fa1',
      },
      fontFamily: {
        headline: ['Epilogue', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        body: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      animation: {
        'pulse-glow': 'pulseGlow 2s infinite ease-in-out',
        'slide-in': 'slideIn 0.3s ease-out',
        'fade-in': 'fadeIn 0.2s ease-in',
      },
      keyframes: {
        pulseGlow: {
          '0%, 100%': { opacity: '0.6', transform: 'scale(1)' },
          '50%': { opacity: '1', transform: 'scale(1.05)' },
        },
        slideIn: {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
      },
    },
  },
  plugins: [],
}
