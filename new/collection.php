<?php
    // HTTPS redirect
//    if ($_SERVER['HTTPS'] !== 'on') {
//		$redirectURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//		header("Location: $redirectURL");
//		exit;
//	}
    
	// Every time we want to access $_SESSION, we have to call session_start()
	if(!session_start()) {
		header("Location: error.php");
		exit;
	}
	
	$loggedIn = empty($_COOKIE['loggedin']) ? false : $_COOKIE['loggedin'];
	if (!$loggedIn) {
        echo "You are unauthorized to view this page. Please log in.";
		exit;
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Grab</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="./collection.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

        <div id="leftBar">
            <div class="leftTab">
                <div></div>
                <a href="#" class="closeLink" data-type="Movies">Movies</a>
            </div>
            <div class="leftTab">
                <div></div>
                <a href="#" class="closeLink" data-type="Music">Music</a>
            </div>
            <div class="leftTab">
                <div></div>
                <a href="#" class="closeLink" data-type="Games">Games</a>
            </div>
            <div class="leftTab">
                <div></div>
                <a href="#" class="closeLink" data-type="Books">Books</a>
            </div>
        </div>

        <div id="focus">
            <div class="labelDiv">
                <label for="collName">Name of Collection<p class="red"><sup>*</sup></p>:</label>
                <input id="collName" type="text" name="collName" placeholder=' "90s Movies" or "Fav Sodas" ' maxlength="255" title="This field is required" required>
            </div>

            <div class="labelDiv">
                <label for="collType">Type of Collection<p class="red"><sup>*</sup></p>:</label>
                <input id="collType" type="text" name="collType" placeholder=' "Movies" or "Soda" ' maxlength="255" title="This field is required" required>
            </div>

            <div class="labelDiv">
                <label for="itemName">Item Search:</label>
                <input id="itemName" type="text" name="itemName" placeholder=' "Zombieland" or "Dr Pepper" ' maxlength="255">
            </div>

            <a href="#" id="itemSearchButton" class="labelDiv closeLink">
                <img src="../images/mag.png" alt="searchbutton" height="20" width="20"> 
            </a>

            <a href="#" id="saveButton">Save Collection</a>



        </div>

        <div id="wikiContent"></div>

        <script>

            $(document).on("click",".leftTab",function(){
                var dataType = $(this).find("a").attr('data-type');
                dataType = dataType.toLowerCase();
                dataType = dataType.charAt(0).toUpperCase() + dataType.slice(1);
                document.getElementById("collType").value = dataType;
            });

            $(document).on("click","#itemSearchButton",function(){
                $("#wikiContent").empty();
                var searchString = $("#itemName").val();
                var query = "https://en.wikipedia.org/w/api.php?action=opensearch&origin=*&search="+ searchString + "&namespace=0&format=xml";

                //Wikipedia Search: 
                //?action=opensearch = invoke search
                //&search="+ $searchString + " = search for content
                //&limit=1 = return x results
                //&namespace=0 = search only articles
                //&format=xml = return as xml (json doesn't include image)
                //&origin=* = tell wikipedia to respond to any origin

                $.ajax({
                    url: query,
                    type: 'GET', 
                    dataType: 'xml',
                    success: function(returnedXMLResponse){
                        console.log("Returned response: ");
                        console.log(returnedXMLResponse);
                        $('Item', returnedXMLResponse).each(function(){
                            var name = $('Text', this).text();
                            var description = $('Description', this).text();
                            var link = $('Url', this).text();
                            var image = $('Image', this).attr('source');
                            CreateNewBox(name, description, link, image);
                        });
                    }
                });
            });

            function CreateNewBox(name, description, link, image) {
                if (!description.includes(" may refer to:")) {

                    var output = "<div class='wikiBox' data-name='" + name + "' data-description='" + description + "' data-link='" + link + "'";
                    if (image) {
                        output += " data-image='" + image + "'";
                    }
                    output += "><a class='grab closeLink removable' href='#'>Grab</a><p>" + name + "</p>";
                    if (image) {
                        output += "<img src='" + image + "' class='imgg removable'>";
                    }
                    output += "<p class='removable'>" + description + "</p><a target='_blank' href='" + link + "' class='removable'>" + link + "</a></div>";

                    $('#wikiContent').append(output);
                }
            }

            $(document).on("click",".grab",function(){
                var clone = $(this).parent().clone();
                clone.find(".removable").remove();
                clone.append("<a class='delItem closeLink' href='#'>X</p>");
                clone.appendTo("#focus");
            });

            $(document).on("click",".delItem",function(){
                $(this).parent().remove();
            });

            $(document).on("click","#saveButton",function(){
                var owner = null; //easier to get with php
                var collectionName = $('#collName').val();
                var collectionType = $('#collType').val();

                if (collectionName && collectionType) {
                    
                    $("#focus .wikiBox").each(function() {
                        var itemName = $(this).attr("data-name");
                        var itemDescription = $(this).attr("data-description");
                        var itemLink = $(this).attr("data-link");
                        var itemImage = $(this).attr("data-image");

                        if (itemName) {
                            if (!itemImage)
                                itemImage = "";

                            $.post("saveCollection.php", { 
                                action: 'save',
                                dataType: 'text',
                                owner: owner,
                                collectionName: collectionName,
                                collectionType: collectionType,
                                itemName: itemName,
                                itemDescription: itemDescription,
                                itemLink: itemLink,
                                itemImage: itemImage,

                                success: function(msg){
                                    $('#saveButton').replaceWith('<a href="#" id="usedSaveButton">Saved!</a>');
                                    $('.wikiBox').remove();
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {

                                }
                            });
                        }
                    });
                }
            });
        </script>
        </body>
</html>