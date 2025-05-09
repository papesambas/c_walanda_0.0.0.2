// Initialisation de Select2
$(document).ready(function() {
    $('.select-profession').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez ou entrez une Professions... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });

    $('.select-cercle').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez ou entrez un cercle... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });

    $('.select-commune').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez ou entrez une commune... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });
    $('.select-lieu').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez ou entrez un lieu de naissance... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });
    $('.select-classe').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez ou entrez une classe... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });
    $('.select-statut').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez ou entrez un statut... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });
    $('.select-scolarite').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez ou entrez une scolarité... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });
    $('.select-redoublement').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez ou entrez un redoublement... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });
    $('.select-nom').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez ou entrez un nom... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });
    $('.select-prenom').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez ou entrez un prénom... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });
    $('.select-region').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez ou entrez une région... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });
    $('.select-niveau').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez ou entrez un niveau... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });
    $('.select-ecole').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez une école... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });
    $('.select-scolarite').select2({
        theme: 'bootstrap-5',
        width: '100%',
        tags: true,
        tokenSeparators: [',', '  '],
        placeholder: 'Sélectionnez une scolarité... ',
        allowClear: true,
        minimumInputLength: 1,
        minimumResultsForSearch: -1 // Pour toujours afficher la recherche même si peu de résultats
    });


});

// Fonction générique pour initialiser Select2
/*function initializeSelect2(selector, options = {}) {
    $(selector).select2(Object.assign({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Sélectionnez une option',
        allowClear: true,
        minimumInputLength: 1,
        language: {
            noResults: () => "Aucun résultat trouvé",
            searching: () => "Recherche en cours..."
        }
    }, options));
}*/

// Exécution à la fin du chargement de la page
/*document.addEventListener('DOMContentLoaded', () => {
    const elements = document.querySelectorAll('.select2');
    elements.forEach((element) => {
        initializeSelect2(element, {
            ajax: {
                url: element.dataset.ajaxUrl,
                dataType: 'json',
                delay: 250,
                cache: true,
                data: (params) => ({
                    q: params.term
                }),
                processResults: (data) => ({
                    results: data.items
                })
            }
        });
    });
});*/

// Optionnel : tu peux exporter initializeSelect2 si besoin ailleurs
//export { initializeSelect2 };
