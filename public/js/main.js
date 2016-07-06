/**
 * Created by Sebastian on 2016-07-05.
 */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

Vue.component('tasks', {
    template: '#tasks-template',
    data: function () {
        return {
            errors: {},
            date: null,
            newTask: null,
            list: []
        }
    },
    created: function() {
      this.fetchTaskList();
    },
    computed: {
      done: function(){
          return this.list.filter(function(item){
              return item.completed == 1;
          });
      },
      todo: function(){
          return this.list.filter(function(item){
              return item.completed == 0;
          });
      },
      checkErrorsPresent: function(){
          return !$.isEmptyObject(this.errors);
      }
    },
    methods: {
        fetchTaskList: function(){
            $.getJSON('api/tasks', function(tasks){
                this.list = tasks;
            }.bind(this));
        },
        toggleStatus: function (task) {
            $.post('api/task/status', {id: task.id} , function(response) {
                if(response.success){
                    this.fetchTaskList();
                }
            }.bind(this), 'json');
        },
        deleteTask: function(task){
            $.post('api/task', {id: task.id, _method : 'DELETE'} , function(response) {
                if(response.success){
                    this.fetchTaskList();
                }
            }.bind(this), 'json');
        },
        addNewTask: function(){
            $.post('api/task', {body: this.newTask, date: this.date , _method : 'PUT'})
            .done(
                function(response) {
                    if(response.success){
                        this.fetchTaskList();
                        this.newTask = null;
                        this.date = null;
                        this.errors = {};
                    }
                }.bind(this)
            , 'json')
            .fail(function(response) {
                this.errors = response.responseJSON;
            }.bind(this));
        }
    }
})

new Vue({
    el: '#task-app'
});