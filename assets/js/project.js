var environ = window.location.host;

if (environ === "localhost") {
  var baseurl = window.location.protocol + "//" + window.location.host + "/" + "rubyinvoice/";
} else {
  var baseurl = window.location.protocol + "//" + window.location.host + "/";
}

var cid = window.location.pathname.split('/').pop();

var app = angular.module('projectApp', ['mm.foundation'])
  .controller('ProjectController', ['$scope', '$http', function($scope, $http) {

    $scope.convertToHours = function(total_time) {
      var time_unit = 3600; // time measured in seconds
      time_hours = (total_time / time_unit).toFixed(2);
      return time_hours;
    }

    calcTimers = function() {
      var timers_combined = 0;
      var time_unit = 3600; // time measured in seconds
      var index;
      var index2;
      var index3;



        for (index = 0; index < $scope.project_object.length; ++index) { // PROJECT LOOP
          total_time = 0;

          if ($scope.project_object[index].tasks) {

            for (index2 = 0; index2 < $scope.project_object[index].tasks.length; ++index2) { // TASK LOOP

              var total_time = 0;

               if ($scope.project_object[index].tasks[index2].timers) {

                 for (index3 = 0; index3 < $scope.project_object[index].tasks[index2].timers.length; ++index3) { // TIMER LOOP

                   total_time += parseInt($scope.project_object[index].tasks[index2].timers[index3].time);
                   time_hours = (total_time / time_unit).toFixed(2);
                   $scope.project_object[index].tasks[index2].time_total = time_hours;
                }

                division = (total_time / time_unit) / $scope.project_object[index].tasks[index2].time_estimate;
                hour_percent = Math.round((division * 100).toFixed(2));

                if (hour_percent == Number.POSITIVE_INFINITY || hour_percent == Number.NEGATIVE_INFINITY) {
                  hour_percent = 0;
                }

                $scope.project_object[index].tasks[index2].percent_complete = hour_percent;

              } else {
                $scope.project_object[index].tasks[index2].percent_complete = 0;
              }
            }
        }
      }
    }

    // GET PROJECT JSON
    $scope.loadProjects = function () {
     $http.get(baseurl+'index.php/clients/get_project_json/'+cid).success(function(data) {
       if (typeof data === "undefined" || data == "null") {
         $scope.project_object = {};
         $scope.setProject("Sample Project");

       } else {
         $scope.project_object = data;
         console.log(data);
         calcTimers();
       }
     });
    };

    $scope.loadProjects(); //initial load

    $scope.setProject = function(prj_name) {

      update = typeof update !== 'undefined' ? update : 'false'; // set this to false by default
      id = typeof id !== 'undefined' ? id : null; // set this to false by default

      $http({
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        url: baseurl+'index.php/clients/set_project',
        method: "POST",
        data: $.param({
          "prj_name" : prj_name,
          "cid" : cid
        }),
      })
      .success(function(data) {
        pid = String(data.project_id);

        $scope.project_object.unshift({
          project_id: pid,
          project_name: data.project_name
        });
        //console.log($scope.project_object);
      });
    };

    $scope.editProject = function(prj, prj_name) {

      $http({
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        url: baseurl+'index.php/clients/set_project',
        method: "POST",
        data: $.param({
          "prj_name" : prj_name,
          "cid" : cid,
          "project_id" : prj.project_id,
          "status" : prj.status
        }),
      })
      .success(function(data) {
        $.extend(true, prj, {
          "project_name": prj_name,
          "status":prj.status
        });
      });
    };

    $scope.deleteProject = function(prj) {
      $http({
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        url: baseurl+'index.php/clients/delete_project',
        method: "POST",
        data: $.param({
          "project_id" : prj.project_id,
          "cid" : cid
        }),
      })
      .success(function(data) {
        //console.log(data);
      });
    }

    $scope.setTask = function(id, tname, trate, testimate, pid, update) {

      update = typeof update !== 'undefined' ? update : 'false'; // set this to false by default
      id = typeof id !== 'undefined' ? id : null; // set this to false by default

      $http({
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        url: baseurl+'index.php/clients/set_task',
        method: "POST",
        data: $.param({
          "id" : id,
          "task_name" : tname,
          "project_id" : pid,
          "cid" : cid,
          "rate" : trate,
          "time_estimate" : testimate,
          "update" : update
        }),
      })
      .success(function(data) {
        //console.log(data);
      });
    };

    $scope.addTaskRow = function(prj, tname, trate, testimate) {

      $http({
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        url: baseurl+'index.php/clients/set_task',
        method: "POST",
        data: $.param({
          "task_name" : tname,
          "project_id" : prj.project_id,
          "cid" : cid,
          "rate" : trate,
          "time_estimate" : testimate
        }),
      })
      .success(function(data) {

        if (!prj.tasks) {
          prj.tasks = [];
        }
        data.percent_complete = 0;
        tid = String(data.id);
        data.id = tid;
        prj.tasks.push(data);

        prj.task_form = false;

        //console.log(data);
      });
    };

    $scope.deleteTask = function(id) {

      $http({
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        url: baseurl+'index.php/clients/delete_task',
        method: "POST",
        data: $.param({
          "id" : id
        }),
      })
      .success(function(data) {
        //$scope.entries = data;
      });
    };


    $scope.deleteTimer = function(id, action) {

      $http({
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        url: baseurl+'index.php/clients/'+action,
        method: "POST",
        data: $.param({
          "timer_id" : id
        }),
      })
      .success(function(data) {
        //$scope.entries = data;
        console.log(data);
      });
    };


    // PROJECT CREATION INTERACTIONS
    /*
    $scope.addProjectRow = function(prj) {
      $scope.project_object.push({
        project_name: prj
      });
    };
    */

    $scope.getProjectForm = function() {
      return baseurl+'assets/html/project-form.html';
    }

    $scope.getEditProjectForm = function() {
      return baseurl+'assets/html/edit-project-form.html';
    }

    $scope.getProjectTemplate = function () {
      return baseurl+'assets/html/project-row.html';
    }

    $scope.showProjectForm = function() {
      $scope.pform = true;
    }

    $scope.hideProjectForm = function() {
      $scope.pform = false;
    }

    $scope.hideEditProjectForm = function(prj) {
      prj.project_form = false;
    }

    $scope.showEditProjectForm = function(prj){
      prj.project_form = true;
    }

    $scope.removeProject = function(prj_index, prj) {
      $scope.deleteProject(prj);
      $scope.project_object.splice(prj_index, 1);
      //console.log(prj);
    }


    // TASK CREATION INTERACTIONS

    $scope.editTaskRow = function(task, task_name, task_rate, task_estimate) {

      $.extend(true, task, {
        "task_name":task_name,
        "rate":task_rate,
        "time_estimate":task_estimate,
        "task_form":false
      });
      $scope.setTask(task.id, task_name, task_rate, task_estimate, task.project_id, "true");
      calcTimers();
    };

    $scope.removeTaskRow = function(prj, task, task_index) {

      $scope.deleteTask(task.id);
      $scope.project_object[prj].tasks.splice(task_index, 1);

      if ( $scope.project_object[prj].tasks.length <= 0 ) {
        $scope.project_object[prj].task_form = false;
      }
      //console.log($scope.project_object[prj].tasks);
      //console.log(task_index);
    }

    $scope.getTaskForm = function() {
      return baseurl+'assets/html/task-form.html';
    }

    $scope.getEditTaskForm = function() {
      return baseurl+'assets/html/edit-task-form.html';
    }

    $scope.getTaskTemplate = function () {
      return baseurl+'assets/html/task-row.html';
    }

    $scope.showTaskForm = function(prj){
      prj.task_form = true;
      //console.log(prj);
    }

    $scope.hideTaskForm = function(prj) {
      prj.task_form = false;
    }

    $scope.showEditTaskForm = function(task){
      task.task_form = true;
    }

    $scope.hideEditTaskForm = function(task){
      task.task_form = false;
    }

    // TIMER CREATION INTERACTIONS
    $scope.getTaskTimer = function() {
      return baseurl+'index.php/clients/view_timer/'+$scope.timerId;
    }

    $scope.setTimerId = function(task) {
      $scope.timerId = task.id;
      //console.log(task);
    }

    $scope.getTimerRows = function() {
      return baseurl+'assets/html/timer-row.html';
    }

    $scope.removeRecord = function(id, action, prj, task, index) {
      $scope.project_object[prj].tasks[task].timers.splice(index, 1);
      calcTimers();
      $scope.deleteTimer(id, action);
    }

}]);