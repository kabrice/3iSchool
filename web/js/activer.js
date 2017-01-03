angular.module("QuestionRest", ['ngResource'])

    .factory("question",  function ( $resource) {

     
        var apiData = $resource(
            "/api", {},
            {
                "postQuestion" : { method: "POST", url: "/api/readQuestion/:containid/:userid/:typeid/Questions"}
            });

        return {

            postQuestion: function(question, contain_id, user_id, type_id) {
                apiData.postQuestion(question, {containid: contain_id, userid: user_id, typeid: type_id}, function() {
                    console.log("Success !");
                }, function(error) {
                    console.log("Error " + error.status + " when sending request : " + error.data);
                });

            }

        }
    });