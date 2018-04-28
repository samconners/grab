<!DOCTYPE html>
<html>
    <head>
        <title>Gallery</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="./gallery.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

        <div id="leftBar"></div>

        <div id="focus">
            <div class="labelDiv">
                <label for="collOwner">Search by Collection Owner:</label>
                <input id="collOwner" type="text" name="collOwner" placeholder=' "Sean" or "Larry" ' maxlength="255">
            </div>

            <div class="labelDiv">
                <label for="collName">Search by Collection Name:</label>
                <input id="collName" type="text" name="collName" placeholder=' "90s Movies" or "Fav Sodas" ' maxlength="255">
            </div>

            <div class="labelDiv">
                <label for="collType">Search by Collection Type:</label>
                <input id="collType" type="text" name="collType" placeholder=' "Movies" or "Soda" ' maxlength="255">
            </div>

            <a href="#" id="itemSearchButton" class="labelDiv closeLink">
                <img src="../images/mag.png" alt="searchbutton" height="20" width="20"> 
            </a>

        </div>

        <div id="wikiContent"></div>

        <script>

            var searchType = location.hash.replace(/#/, "");
            if (searchType !== "undefined")
                Search("", "", searchType, "get_collection_set");


            $(document).on("click",".x",function(){
                //DO SQL DELETE HERE
                var collectionName = $(this).prev().attr("data-collName");
                var collectionType = $(this).prev().attr("data-collType");
                console.log("Parent: " + collectionName + " " + collectionType);
                DeleteCollection(collectionName, collectionType);
                $(this).parent().empty();
                return false;
            });

            $(document).on("click","#itemSearchButton",function(){
                $("#wikiContent").empty();

                var owner = $("#collOwner").val();
                var collectionName = $("#collName").val();
                var collectionType = $("#collType").val();

                Search(owner, collectionName, collectionType, "get_collection_set");
            });
            
            $(document).on("click",".wikiBox",function(){

                var owner = $(this).attr("data-owner");
                var collectionName = $(this).attr("data-collName");
                var collectionType = $(this).attr("data-collType");

                $("#wikiContent").empty();
                Search(owner, collectionName, collectionType, "get_collection");
            });

            function Search(owner, collectionName, collectionType, action) {
                $.ajax ({ 
                    type: "POST",
                    url: "getCollection.php",
                    data: {
                        action: action,
                        owner: owner,
                        collectionName: collectionName,
                        collectionType: collectionType,
                    },
                    success: function(data){
                        if(!data)
                            console.log("NO DATA RECEIVED");
                        $('#wikiContent').append(data);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest + textStatus + errorThrown);
                    }
                });
            }

            function DeleteCollection(collectionName, collectionType) {
                $.ajax ({ 
                    type: "POST",
                    url: "delete.php",
                    data: {
                        collectionName: collectionName,
                        collectionType: collectionType,
                    },
                    success: function(data){
                        if(!data)
                            console.log("NO DATA RECEIVED");
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest + textStatus + errorThrown);
                    }
                });
            }

        </script>
        </body>
</html>