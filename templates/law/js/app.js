import Alpine, { startAlpine } from '../../../resources/js/site.js';

/* Kaynak filtre formu: tür seçimi değişince otomatik gönder */
Alpine.data('publicationFilters', () => ({
    submit() {
        this.$root.requestSubmit();
    },
}));

startAlpine();
