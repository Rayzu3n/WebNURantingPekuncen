import React from 'react';
import { useApp } from '../context/AppContext';
import { Sun, Moon } from 'lucide-react';

export const ThemeToggle: React.FC = () => {
  const { darkMode, toggleDarkMode } = useApp();

  return (
    <button
      type="button"
      onClick={toggleDarkMode}
      aria-label="Toggle dark mode"
      className="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#d9ddd9] bg-white text-[#4A5550] shadow-sm transition hover:bg-gray-50 dark:border-[#2b312d] dark:bg-[#181c1a] dark:text-[#bbcabf] dark:hover:bg-[#222724]"
    >
      {darkMode ? (
        <Sun className="h-4 w-4 text-amber-400" />
      ) : (
        <Moon className="h-4 w-4 text-slate-700" />
      )}
    </button>
  );
};
