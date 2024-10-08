//this is for all the select2 boxes . . very easy
$(document).ready(function() {
 var sortByMatchIndex;
 $sortByMatchIndex = function(results) {
    var query = $('.select2-search__field').val().toLowerCase();
    return results.sort(function(a, b) {
      return a.text.toLowerCase().indexOf(query) -
        b.text.toLowerCase().indexOf(query);
    });
 };

 $("#tags-ids, #tag").select2({
	placeholder: "Select subject tags",
	allowClear: true,
        width: "100%",
        sorter: $sortByMatchIndex
 });
$("#country").select2({
    placeholder: "Select a country...",
    allowClear: true,
    //allowClear: true,
    width: "100%",
    /* sj - I don't think we need a custom matcher with the current approach, but it might need to be tweaked?
matcher: function(term, text) {
     return text.toUpperCase().indexOf(term.toUpperCase())>=0;
},*/
    templateResult: formatCountry,
    templateSelection: formatCountry,
	sortResults: $sortByMatchIndex
});

//add the placeholder ourselves! Can't get it to work, might have to do with use of <optgroup>
$('.input:has(label[for="country"]) .select2-selection__placeholder').text('Select country...');

function formatCountry(country){
	//must be return as jQuery obj
	var text=country.id; //use the ID rather than name, which has alt spelling search vals
	//if it has children, then its an optgroup (Americas, Asia, etc)
	if (typeof(country.children)!='undefined') text=country.text;
	//otherwise stick with the ID
	return text;
	/* left here as example, if you add HTML need to return as jQ obj*/
	var ctyObj=$("<span style='color:black;'>"+text+"</span>");
	return ctyObj;
}

//add required decoration to tags dropdown
$("label[for='tags-ids']").parent().addClass('required');

//add protocol to homepage
$('#homepage').on('change',function(){
	$(this).val(getValidUrl($(this).val()));
});

//https://stackoverflow.com/questions/11300906/check-if-a-string-starts-with-http-using-javascript
function getValidUrl(url){
    let newUrl = window.decodeURIComponent(url);
    newUrl = newUrl.trim().replace(/\s/g, "");
    if(/^(:\/\/)/.test(newUrl)) return `http${newUrl}`;
    if(!/^(f|ht)tps?:\/\//i.test(newUrl)) return `https://${newUrl}`;
    return newUrl;
};

 //old below
 /*
 $("#TagTag").select2({
	placeholder: "Select subject tags",
	allowClear: true,
        width: "100%",
        sortResults: $sortByMatchIndex
 });

 $("#SearchTag").select2({
	placeholder: "Select subject tags",
	allowClear: true,
        width: "100%",
        sortResults: $sortByMatchIndex
 });

 $("#ConferenceCountry").select2({
        placeholder: "Country...",
        //allowClear: true,
        width: "100%",
	matcher: function(term, text) {
	     return text.toUpperCase().indexOf(term.toUpperCase())>=0;
	},
	sortResults: $sortByMatchIndex

 });
 */
});
