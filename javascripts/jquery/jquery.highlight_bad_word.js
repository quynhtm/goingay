jQuery(function() {
 jQuery.show_badwords = document.body.createTextRange ? 

/*
Version for IE using TextRanges.
*/
function(node, te) {
	te=te.toUpperCase();
	var r = document.body.createTextRange();
	r.moveToElementText(node);
	for (var i = 0; r.findText(te); i++) {
		r.pasteHTML('<span class="highlightBadword">' +  r.text + '<\/span>');
		r.collapse(false);
	}
}

 :

/*
 (Complicated) version for Mozilla and Opera using span tags.
*/
function(node, te) { 
	te=te.toUpperCase();
	var pos, skip, spannode, middlebit, endbit, middleclone;
	skip = 0;
	if (node.nodeType == 3) {
		pos = node.data.toUpperCase().indexOf(te);
		if (pos >= 0) {
			spannode = document.createElement('span');
			spannode.className = 'highlightBadword';
			middlebit = node.splitText(pos);
			endbit = middlebit.splitText(te.length);
			middleclone = middlebit.cloneNode(true);
			spannode.appendChild(middleclone);
			middlebit.parentNode.replaceChild(spannode, middlebit);
			skip = 1;
		}
	}
	else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
		for (var i = 0; i < node.childNodes.length; ++i) {
			i += jQuery.show_badwords(node.childNodes[i], te);
		}
	}
	return skip;
};

});