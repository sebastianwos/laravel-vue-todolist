@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <div id="task-app" class="row">
                        <tasks></tasks>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<template id="tasks-template" v-if="list.length">
    <div class="col-md-4">
        <h2>Add new task</h2>
        <form class="form" @submit.prevent="addNewTask">
            <div v-if="checkErrorsPresent" class="alert alert-danger" role="alert">
                <ul>
                    <li v-for="error in errors">
                        @{{ error[0] }}
                    </li>
                </ul>
            </div>
            <div class="form-group">
                <label class="sr-only" for="exampleInputPassword3">New Task</label>
                <textarea rows="10" v-model="newTask" class="form-control"  placeholder="New Task" required></textarea>
            </div>
            <div class="form-group">
                <label class="sr-only" for="exampleInputPassword3">New Task</label>
                <input class="form-control" type="date" v-model="date" required />
            </div>
            <button type="submit" class="btn btn-default">Add new task</button>
        </form>
    </div>
    <div class="col-md-4">
        <h2>To do list</h2>
        <ul v-if="todo.length" class="list-group">
            <li class="list-group-item" v-for="task in todo">
                <div class="panel panel-default">
                    <div class="panel-heading">Date: <span class="label label-default">@{{ task.end_date }}</span></div>
                    <div class="panel-body">
                        @{{ task.body }}
                    </div>
                    <div class="panel-footer clearfix">
                        <a class="btn btn-xs btn-danger" @click.prevent="deleteTask(task)" href="#">
                            <span class="glyphicon glyphicon-remove-circle"></span>
                            Delete
                        </a>
                        <a class="btn btn-xs btn-primary" @click.prevent="toggleStatus(task)" href="#">
                            <span class="glyphicon glyphicon-ok-circle"></span>
                            Done !
                        </a>
                    </div>
                </div>
            </li>
        </ul>
        <div v-else class="alert alert-info" role="alert">
            No tasks to do
        </div>
    </div>
    <div class="col-md-4">
        <h2>Done list</h2>
        <ul v-if="done.length" class="list-group">
            <li v-if="task.completed" class="list-group-item" v-for="task in done">
                <div class="panel panel-success">
                    <div class="panel-heading">Date: <span class="label label-default">@{{ task.end_date }}</span></div>
                    <div class="panel-body">
                        @{{ task.body }}
                    </div>
                    <div class="panel-footer clearfix">
                        <a class="pull-right btn btn-xs btn-danger" @click.prevent="deleteTask(task)" href="#">
                            <span class="glyphicon glyphicon-remove-circle"></span>
                            Delete
                        </a>
                    </div>
                </div>
            </li>
        </ul>
        <div v-else class="alert alert-info" role="alert">
            No tasks done yet
        </div>
    </div>
</template>

@endsection

@section('scripts')
    <script type="text/javascript" src="/js/vue.js"></script>
    <script type="text/javascript" src="/js/main.js"></script>
@endsection
