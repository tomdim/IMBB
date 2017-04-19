var movies = [];
var indexesToDisplay = [];

function Movie(title, year, genre, image, synopsis, ratings, numOfVotes) {
  this.title = title;
  this.year = year;
  this.genre = genre;
  this.image = image;
  this.synopsis = synopsis;
  this.ratings = ratings;
}

/******************************************************************************/

function searchMovies(genre)
{

  var param = 'genre='+genre;
  var xhttp = new XMLHttpRequest();
  xhttp.open('POST', 'search.php', true);

  xhttp.setRequestHeader(
      'Content-Type',
      'application/x-www-form-urlencoded'
  );

  xhttp.onreadystatechange = function ()
  {
     if (xhttp.readyState === 4 && xhttp.status === 200)
     {
         response = xhttp.responseText;
         if(response.startsWith('ERROR:'))
         {
            alert(response.substring(7));
         }
         else
         {
            var title, year, genre, image, synopsis, ratings;
            var res = response.split(" | ");

            if(document.getElementById("search-results") != null)
            {
              document.getElementById("search-results").remove();
            }
            indexesToDisplay = [];

            for (var i=0; i<(res.length/5); i++)
            {

                title = res[(i*5)+0];
                year = res[(i*5)+1];
                genre = res[(i*5)+2];
                image = res[(i*5)+3];
                synopsis = res[(i*5)+4];

                var index = -1;
                for(var j = 0; j < movies.length; j++)
                {
                    if(movies.length === 0)
                    {
                        break;
                    }
                    if (movies[j].title === title) {
                        index = j;
                        break;
                    }
                }

                if(index === -1)
                {
                    var movie = new Movie(title, year, genre, image, synopsis, 0);
                    movies.push(movie);
                    indexesToDisplay.push(movies.length - 1);
                }
                else
                {
                    indexesToDisplay.push(index);
                }
                getRatings(indexesToDisplay[i]);
            }

            sort(document.getElementById('sort').value);
        }
    }
  };
  xhttp.send(param);
}

Element.prototype.remove = function() {
    this.parentElement.removeChild(this);
}
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = this.length - 1; i >= 0; i--) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
}

/******************************************************************************/

function sort(orderby)
{
  var sortedMovies = [];
  if(orderby === "title")
  {
      for(var i = 0; i < indexesToDisplay.length; i++)
      {
        sortedMovies[i] = movies[indexesToDisplay[i]];
      }

      sortedMovies.sort(function(a, b){
          var title1 = a.title.toLowerCase();
          var title2 = b.title.toLowerCase();
          if (title1 < title2) //sort string ascending
            return -1;
          if (title1 > title2)
            return 1;
          return 0; //default return value (no sorting)
      });

  }
  else if (orderby === "rate-asc")
  {
      for(var i = 0; i < indexesToDisplay.length; i++)
      {
        sortedMovies[i] = movies[indexesToDisplay[i]];
      }

      sortedMovies.sort(function(a, b){
         return a.ratings-b.ratings
      });

  }
  else if (orderby === "rate-desc")
  {
    for(var i = 0; i < indexesToDisplay.length; i++)
    {
      sortedMovies[i] = movies[indexesToDisplay[i]];
    }

    sortedMovies.sort(function(a, b){
       return b.ratings-a.ratings
    });

  }
  displayResults(sortedMovies);
}

/******************************************************************************/

function displayResults(sortedMovies)
{

  if(document.getElementById("search-results") != null)
  {
    document.getElementById("search-results").remove();
  }

  var column, row, table;
  table = document.createElement('table');
  table.setAttribute("id", "search-results");
  row = table.insertRow(0);
  column = row.insertCell(0);
  column.innerHTML = "Image";
  column = row.insertCell(1);
  column.innerHTML = "Title";
  column = row.insertCell(2);
  column.innerHTML = "User Ratings";

  for(var i = 0; i < sortedMovies.length; i++)
  {
    row = table.insertRow(i+1);
    column = row.insertCell(0);
    column.innerHTML = "<img class=\"movie_icon\" src=" + sortedMovies[i].image + "></img>";
    column = row.insertCell(1);
    var title = sortedMovies[i].title;
    column.innerHTML = "<a id=\"movie_title\" name=\"" + title + "\"  onClick=\"storeMovieL(this.name)\" href=\"movie_page.php?title=" + title + "\">" + sortedMovies[i].title + "</a>";
    column = row.insertCell(2);
    column.innerHTML = sortedMovies[i].ratings + " out of 5";
  }
  document.getElementById("movie-list").appendChild(table);
}

/******************************************************************************/

function getRatings(index)
{
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', 'ratings.php', false);
    xhttp.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded'
    );

    var param = 'title='+ movies[index].title;
    //alert(param);
    xhttp.onreadystatechange = function ()
    {
       if (xhttp.readyState === 4 && xhttp.status === 200)
       {
           response = xhttp.responseText;
           movies[index].ratings = response;
           //alert(movies[index].title + "  " + response);
       }
    };
    xhttp.send(param);
}

/******************************************************************************/

function storeMovieL(title)
{
  var index;
  for(var i = 0; i < movies.length; i++)
  {
    if(movies[i].title === title)
    {
      index = i;
    }
  }
  var movie = { 'title': movies[index].title,
                'year': movies[index].year,
                'genre': movies[index].genre,
                'image': movies[index].image,
                'synopsis': movies[index].synopsis ,
              };

  localStorage.setItem('movie', JSON.stringify(movie));
}

/******************************************************************************/

function loadMoviePage(title, ratings, user_rate)
{
    var movieObj = JSON.parse(localStorage.getItem('movie'));

    console.log('movieObj: ', movieObj);

    document.getElementById('year').innerHTML = movieObj.year;
    document.getElementById('genre').innerHTML = movieObj.genre;
    document.getElementById('image').src = movieObj.image;
    document.getElementById('synopsis').innerHTML = movieObj.synopsis;

    initStars(ratings, user_rate);
}

/******************************************************************************/

function initStars(avg_rate, user_rate)
{
  var loggedin;
  if(avg_rate != "")
  {
    currentValue = Math.round( avg_rate );
    loggedin = false;
  }
  else if (user_rate != "")
  {
    currentValue = Math.round( user_rate );
    loggedin = true;
  }
	var matches = document.querySelectorAll('form.rating-stars');

  var form = matches[0],
	    input = form.querySelector('input[type="range"]'),
	    size = input.getAttribute('max'),
	    ratingStars = document.createElement('span');

	ratingStars.className = 'rating-stars';

		for(var j=size; j>0; j--) {
			var star = document.createElement('a'), // <a href />, to be focusable
				rating = j;
			star.href = '#';
			star.rating = rating;

			if( currentValue && rating == currentValue) {
				star.className = 'selected';
			}

      if(loggedin){
        star.addEventListener('click', rate, false);
      }

			ratingStars.appendChild(star);
		}

		// Insert the widget where the <input> used to be
		input.parentNode.replaceChild(ratingStars, input);

		// Remove the button
		var button = form.getElementsByTagName('button')[0];
		if(button) {
			button.parentNode.removeChild(button);
		}
}

/******************************************************************************/

function rate(evt)
{
	var form = this.parentNode;
  var me = this;

	while(form.nodeName.toLowerCase() != 'form') {
		form = form.parentNode;
	}

	var method = form.method;

	this.blur(); // Lose focus to prevent re-submitting

	var data = 'rating=' + this.rating;

	var params = data + title;
  var xhttp = new XMLHttpRequest();
  xhttp.open('POST', 'rate.php', true);

  xhttp.setRequestHeader(
      'Content-Type',
      'application/x-www-form-urlencoded'
  );

  xhttp.onreadystatechange = function (evt) {
       if(xhttp.status == 4 || xhttp.status == 200 || xhttp.status == 302) {
        var response = xhttp.responseText;

        if(response != null) {
            var otherstars = me.parentNode.getElementsByTagName('a');

            for(var i=0; i<otherstars.length; i++) {
              otherstars[i].removeAttribute('class');
            }

            me.className = 'selected-by-me';

            var currentValue = response;
            window.location.reload();
        }
      }
      else {
        alert('Error ' + xhttp.status + ': ' + xhttp.statusText);
      }
  };
  xhttp.send(params);
	evt.preventDefault();

}
