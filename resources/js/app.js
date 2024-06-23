import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

import { loadSuggestions, voteForSuggestion } from './suggestion-system';

window.loadSuggestions = loadSuggestions;
window.voteForSuggestion = voteForSuggestion;

Alpine.start();
