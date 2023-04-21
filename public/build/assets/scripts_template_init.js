//INICIANDO SCRIPTS QUE FORAM MIX NO scripts_template.js

//Select2
if ($('select').hasClass('select2')) {
    $(".select2").select2();
}

if ($('select').hasClass('select2-limiting')) {
    $(".select2-limiting").select2({maximumSelectionLength:2});
}

if ($('select').hasClass('select2-search-disable')) {
    $(".select2-search-disable").select2({minimumResultsForSearch:1/0});
}
