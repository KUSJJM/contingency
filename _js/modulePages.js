// Desktop Section Switcher
// Declare globals to hold all the links and all the panel elements
var moduleLinks;
var moduleSections;
   
// when the page loads, grab the secondary nav anchor elements
moduleLinks = document.getElementsByTagName("nav")[1].getElementsByTagName("a");
// Now get all the articles
moduleSections = document.getElementsByTagName("main")[0].getElementsByTagName("article");

// activate the _first_ one
displaySection(moduleLinks[0]);

// attach event listener to links using onclick and onfocus
// fire the displaySection function, return false to disable the link
for (var i = 0; i < moduleLinks.length; i++) {
    moduleLinks[i].onclick = function() { 
        displaySection(this); 
        return false;
    }
}

function displaySection(tabToActivate) {
    // go through all the anchor elements
    for (var i = 0; i < moduleLinks.length; i++) {
        if (moduleLinks[i] == tabToActivate) {
			// if it's the one to activate, change its class
            moduleLinks[i].classList.add("active");
			// and display the corresponding section
			moduleSections[i].style.display = "block";
        } else {
			// remove the active class on the link
        	moduleSections[i].classList.remove("active");
			// hide the section
			moduleSections[i].style.display = "none";
        }
	}
}
