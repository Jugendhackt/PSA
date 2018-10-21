const firstName = new URLSearchParams(window.location.search).get('first');
const secondName = new URLSearchParams(window.location.search).get('second');
var first, second;

$.ajax({
  url: "https://psa1.uber.space/api/twitter/counter/" + firstName,
  type: "get",
  success: result1 => {
  	first = result1;
  	$.ajax({
  		url: "https://psa1.uber.space/api/twitter/counter/" + secondName,
  		async: false,
  		type: "get",
  		success: result2 => { second = result2; statistics() }
	});
  }
});

function statistics() {
	const ctx = document.getElementById("comparisonStat").getContext('2d');
	new Chart(ctx, {
  		type: 'line',
  		data: {
    		datasets: [{
          		label: firstName,
          		data: Object.values(first.hours),
          		borderColor: '#EB4839'
        	}, {
          		label: secondName,
          		data: Object.values(second.hours),
          		type: 'line',
          		borderColor: '#429FCA'

        	}],
    	labels: Object.keys(first.hours)
  	},
  	options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
}