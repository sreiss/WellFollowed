angular.module('wellFollowed').directive('wfSensorTemperatureGraph', function() {
   return {
       restrict: 'E',
       templateUrl: 'sensor/wf-sensor-temperature-graph.html',
       require: '^wfSensor',
       link: function(scope, element, attributes, wfSensor) {

           var margin = {top: 20, right: 20, bottom: 30, left: 50},
               width = element.width() - margin.left - margin.right,
               height = 500 - margin.top - margin.bottom;

           var formatDate = d3.time.format("%d-%b-%y");

           var x = d3.time.scale()
               .range([0, width]);

           var y = d3.scale.linear()
               .range([height, 0]);

           var xAxis = d3.svg.axis()
               .scale(x)
               .orient("bottom");

           var yAxis = d3.svg.axis()
               .scale(y)
               .orient("left");

           var line = d3.svg.line()
               .x(function(d) { return x(d.date); })
               .y(function(d) { return y(d.close); });

           var svg = d3.select(element[0]).append("svg")
               .attr("width", width + margin.left + margin.right)
               .attr("height", height + margin.top + margin.bottom)
               .append("g")
               .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

           var session = wfSensor.getWsSession();
           var data = [];

           x.domain(d3.extent(data, function(d) { return d.date; }));
           y.domain(d3.extent(data, function(d) { return d.value; }));

           svg.append("g")
               .attr("class", "x axis")
               .attr("transform", "translate(0," + height + ")")
               .call(xAxis);

           svg.append("g")
               .attr("class", "y axis")
               .call(yAxis)
               .append("text")
               .attr("transform", "rotate(-90)")
               .attr("y", 6)
               .attr("dy", ".71em")
               .style("text-anchor", "end")
               .text("Température");

           session.subscribe('sensor/data/' + scope.sensor.name, function(uri, payload) {

               scope.$apply(function() {
                   scope.currentTemp = payload.msg.value;
               });

               data.push(payload.msg);

               svg.append("path")
                   .datum(data)
                   .attr("class", "line")
                   .attr("d", line);

           });

       }
   };
});