var tripCount; 
var tripCount2014;
var totalCount;

angular.element(document).ready(function(){
  var cycleRef = new Firebase('https://cyclephilly.firebaseio.com/trips-started/2015/');

  cycleRef.on('value', function(snapshot) {
  var fireTrips = snapshot.val();
    console.log(fireTrips);
    console.log( _.size(fireTrips) );
    console.log( _.keys(fireTrips).length );
    var count = 0;

for (var key in fireTrips) {
   var obj = fireTrips[key]; // this gets us inside the first child/subgroup of the object (months for firebase)
   for (var prop in obj) {

    // console.log(prop);

      // important check that this is objects own property 
      // not from prototype prop inherited
      //console.log("keys =" + _.keys(obj[prop]));
      if(obj.hasOwnProperty(prop)){ // this accesses the days
        

        console.log("for this day" + prop + "- size = " + _.size(obj[prop]));
        count = count + _.size(obj[prop]);

      }
      
   }

}


console.log("All trips count = " + count);
 tripCount = count;
 console.log(tripCount);
 return tripCount;
  });
});


angular.element(document).ready(function(){
  var cycleRef = new Firebase('https://cyclephilly.firebaseio.com/trips-started/2014/');

  cycleRef.on('value', function(snapshot) {
  var fireTrips = snapshot.val();
    console.log(fireTrips);
    console.log( _.size(fireTrips) );
    console.log( _.keys(fireTrips).length );
    var count = 0;

for (var key in fireTrips) {
   var obj = fireTrips[key]; // this gets us inside the first child/subgroup of the object (months for firebase)
   for (var prop in obj) {

    // console.log(prop);

      // important check that this is objects own property 
      // not from prototype prop inherited
      //console.log("keys =" + _.keys(obj[prop]));
      if(obj.hasOwnProperty(prop)){ // this accesses the days
        

        console.log("for this day" + prop + "- size = " + _.size(obj[prop]));
        count = count + _.size(obj[prop]);

      }
      
   }

}


console.log("All trips count = " + count);
 tripCount2014 = count;
 console.log(tripCount2014);
 return tripCount2014;
  });
});

totalCount = tripCount + tripCount2014;
console.log(totalCount);