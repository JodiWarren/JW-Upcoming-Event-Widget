(function ($) {
	"use strict";
	$(function () {

		// Here we initialise the waytoomany variables that I use.
		var jw_timeToUse, jw_days, jw_hours, jw_minutes, jw_seconds, jw_daysSeconds, jw_hoursSeconds, jw_minutesSeconds, jw_totalSeconds, jw_timer;


		// Get the time span. Then for each time period, get the value, turn it into an integer, then check if it's real or a NaN. If it's NaN/null, make it a zero.
		jw_timeToUse = $('.jw_widget_event_time');
		jw_days = realOrZero(
				parseInt(
				jw_timeToUse
					.children('.jw_widget_event_time_days')
					.text()
				)
			);
		jw_hours = realOrZero(
				parseInt(
				jw_timeToUse
					.children('.jw_widget_event_time_hours')
					.text()
				)
			);
		jw_minutes = realOrZero(
				parseInt(
				jw_timeToUse
					.children('.jw_widget_event_time_minutes')
					.text()
				)
			);
		jw_seconds = realOrZero(
				parseInt(
				jw_timeToUse
					.children('.jw_widget_event_time_seconds')
					.text()
				)
			);

		// Get all the seconds
		jw_daysSeconds = jw_days * 24 * 60 * 60;
		jw_hoursSeconds = jw_hours * 60 * 60;
		jw_minutesSeconds = jw_minutes * 60;

		jw_totalSeconds = jw_seconds+jw_minutesSeconds+jw_hoursSeconds+jw_daysSeconds;

		/**
		 * Check if passed number exists. If not, return a 0
		 * @param  string hero Passed number. Is it a zero or a hero?
		 * @return string/int      return what came in if it exists, else return 0.
		 */
		function realOrZero(hero){
			if (hero) {
				return hero;
			} else{
				return 0;
			};
		}

		/**
		 * Throw some seconds in here, and get an array of time out.
		 * @param  int sec Seconds to split into an array
		 * @return array allTime	An array of the various time periods.
		 */
		function convertSecondsToDays(sec) {
		  var allTime,days,hours,rem,mins,secs;
		  days =  parseInt(sec/(24*3600));
		  rem = sec - days*3600
		  hours = parseInt(rem/3600);
		  rem = rem - hours*3600;
		  mins = parseInt(rem/60);
		  secs = rem - mins*60;
		  allTime = [days, hours, mins, secs];
		  return allTime;
		}

		/**
		 * Is it a plural? Does it even exist? These mysteries and more, answered in... jw_is_plural! Only works with plurals that end in s. Octopi need not apply.
		 * @param  int count          The number to check against.
		 * @param   string stringToOutput	Pass in something that would normally end in s (i.e. "beans", and it'll chop off the s if it needs to (i.e. "bean");
		 * @return string                The number and the correct plural, if anything.
		 */
		function jw_is_plural(count, stringToOutput){
			if (count > 1) {
				return count + ' ' + stringToOutput;
			} else if (count === 1){
				return count + ' ' + stringToOutput.slice(0, - 1);
			} else {
				return '';
			}
		}


		function updateCounter() {
			var msg = '';
			var curTime = parseInt(new Date().getTime()/1000);
			var allTime, outputText, trimmedOutputText;

			allTime = convertSecondsToDays(jw_totalSeconds);

			if (jw_timeToUse) {

		  		outputText = jw_is_plural(allTime[0], ' days')+' '+jw_is_plural(allTime[1], ' hrs')+' '+jw_is_plural(allTime[2], ' mins')+' '+jw_is_plural(allTime[3], ' secs');
		  		trimmedOutputText = $.trim(outputText);

		  		if (trimmedOutputText === "") {
		  			jw_timeToUse.html(jw_timeToUse.data('livemessage'));
		  			clearInterval(jw_timer);
		  		} else{
		  			if (allTime[0] === 0 && allTime[1] === 0) {
		  				trimmedOutputText = 'Live in: ' + trimmedOutputText;
		  			}
			  		jw_timeToUse.html(trimmedOutputText);
					jw_totalSeconds = jw_totalSeconds-1;
		  		};
			}
	  	}

	  	jw_timer = window.setInterval(updateCounter, 1000);

	});
}(jQuery));