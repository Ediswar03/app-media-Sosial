import './bootstrap';
import Alpine from 'alpinejs';

// React imports
import React, { createContext, useContext, useState, useEffect } from 'react';
import { createRoot } from 'react-dom/client';

window.Alpine = Alpine;
Alpine.start();

// Utility functions for local storage
const getLocalStorage = (key, parse = true) => {
    try {
        const item = localStorage.getItem(key);
        return item ? (parse ? JSON.parse(item) : item) : null;
    } catch (error) {
        console.error("Error reading from local storage", error);
        return null;
    }
};

const setLocalStorage = (key, value, stringify = true) => {
    try {
        localStorage.setItem(key, stringify ? JSON.stringify(value) : value);
    } catch (error) {
        console.error("Error writing to local storage", error);
    }
};

// 1. Create the Context
export const appContext = createContext(null);

// 2. Create a Provider Component
const AppProvider = ({ children }) => {
    const storedDarkMode = getLocalStorage("darkmode", false);
    const [darkMode, setDarkModeState] = useState(
        storedDarkMode === null ? "light" : storedDarkMode
    );

    const updateDarkMode = (mode) => {
        setDarkModeState(mode);
        setLocalStorage("darkmode", mode, false);
        document.documentElement.setAttribute('data-theme', mode); // Apply theme to HTML tag
    };

    // Initialize theme on component mount
    useEffect(() => {
        document.documentElement.setAttribute('data-theme', darkMode);
    }, [darkMode]);

    // You can add user context or other global states here if needed
    const user = { name: "Guest", email: "guest@example.com" }; // Placeholder user

    return (
        <appContext.Provider
            value={{
                user,
                darkMode,
                setDarkMode: updateDarkMode,
            }}
        >
            {children}
        </appContext.Provider>
    );
};

// 3. Create a simple App component that will use the provider
const App = () => {
    return (
        <AppProvider>
            {/* Your main React application components will go here */}
            {/* For now, we'll render the ThemeToggleButton directly */}
            <ThemeToggleButton />
        </AppProvider>
    );
};

// 4. Create the ThemeToggleButton Component
const ThemeToggleButton = () => {
    const { darkMode, setDarkMode } = useContext(appContext);

    const toggleTheme = () => {
        setDarkMode(darkMode === "light" ? "dark" : "light");
    };

    return (
        <button
            onClick={toggleTheme}
            className="px-4 py-2 text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 dark:text-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors duration-200"
        >
            {darkMode === "light" ? "🌙 Dark Mode" : "☀️ Light Mode"}
        </button>
    );
};

// 5. Mount the React application
const appRoot = document.getElementById('react-app-root');
if (appRoot) {
    createRoot(appRoot).render(<App />);
}

// You can also mount specific React components to specific Blade placeholders
const themeToggleRoot = document.getElementById('theme-toggle-root');
if (themeToggleRoot) {
    createRoot(themeToggleRoot).render(
        <AppProvider> {/* Wrap with provider to access context */}
            <ThemeToggleButton />
        </AppProvider>
    );
}