const $ = require('jquery');

import 'suggestags';

$(document).ready(function() {
    $('[data-toggle="tagsinput"]').amsifySuggestags();
});