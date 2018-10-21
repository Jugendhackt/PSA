let correct = 0;
let maxCorrect = 0;
let allClicked = [];

$.ajax({
	url: "https://psa1.uber.space/api/twitter/random/hanneskeks",
  	type: "get",
  	success: result => {
  		$(".tweetText").empty();
  		result.words.forEach((arr, i) => $(".tweetText").append("<span id='" + i + "'>" + result.words[i] + "</span> "))
  		maxCorrect = result.hashtag_pos.length;
  		$("span").click(event => {
			  if (result.hashtag_pos.indexOf(parseInt(event.target.id)) >= 0 && !allClicked.includes(event.target.id)) correct++;
        if (allClicked.includes(event.target.id)) {
          position = allClicked.indexOf(event.target.id);
          if (~position) allClicked.splice(position, 1);
          $("span#" + event.target.id).css("background-color", "white");
        } else {
          allClicked.push(event.target.id);
          $("span#" + event.target.id).css("background-color", "blue");
        }
		})
  	},
  	error: result => {
  		$(".tweetText").empty();
  		$(".tweetText").html("Bitte versuchen Sie es mit einem anderen Nutzer.")
  	}
})

$(".button").click(event => {
	alert(correct > 0 ? "Jaa! Du hast " + correct == maxCorrect ? correct : maxCorrect + " von " + maxCorrect + " richtig!" : "Schade. Du hast nichts richtig.")
})
