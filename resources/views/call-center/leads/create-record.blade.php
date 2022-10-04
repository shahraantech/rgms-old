@extends('setup.master')
@section('content')
    <style type="text/css">
        body {
            font-family: Arial;
            font-size: 10pt;
        }

        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
        }

        table th {
            background-color: #F7F7F7;
            color: #333;
            font-weight: bold;
        }

        table th,
        table td {
            padding: 5px;
            border: 1px solid #ccc;
        }
    </style>
    <div class="main-wrapper">
        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <div class="page-header my-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title bold-heading"> Leads</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active"> Leads</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"
                                title="Add Inbound Leads"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">


                        <form id="Add_Record_Form" action="{{ url('store-record') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-lg-5 m-auto">

                                    <div class="form-group">

                                        <div class="row mb-3">
                                            <div class="col-lg-5  m-auto ">
                                                {{-- <input type="text" name="file" class="form-control"> --}}
                                                <div class="form-group text-center ">

                                                    <div id="">
                                                        <button class="btn btn-primary" id="record"
                                                            type="button">Start</button>
                                                        <button class="btn btn-secondary" id="pause"
                                                            type="button">Pause</button>
                                                        <button class="btn btn-warning" id="resume"
                                                            type="button">Resume</button>
                                                        <button class="btn btn-danger" id="stop"
                                                            type="button">Stop</button>
                                                    </div>
                                                    <div id="support"></div>
                                                    <div id="list"></div>
                                                    <div id="formats" style="display: none">Format: start
                                                        recording to see sample rate</div>
                                                    <ol class="mt-2 " style="list-style: none;" id="recordingsList"
                                                        class="recordingsList"></ol>
                                                </div>
                                                <button class="btn btn-success submit" id="submit-audio" type="submit">
                                                    Submit</button>
                                            </div>
                                        </div>

                                        <div id="errors"></div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>




    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- audio-->

    <script type="text/javascript" defer="">
        //  Copy AS IT IS
        let EVENTS = ["start", "stop", "pause", "resume"];
        let recorder, list, record, pause, resume, stop;

        let errors = '';

        var records = {};

        record = document.getElementById("record");

        resume = document.getElementById("resume");
        pause = document.getElementById("pause");
        stop = document.getElementById("stop");
        if (MediaRecorder.notSupported) {
            console.log("notsupported")
            list.style.display = "none";
            document.getElementById("controls").style.display = "none";
            document.getElementById("support").style.display = "none";
        } else {
            console.log("supported")

            record.addEventListener("click", (event) => startRecording(event));
            resume.addEventListener("click", resumeRecording);
            pause.addEventListener("click", pauseRecording);
            stop.addEventListener("click", stopRecording);
        }




        function startRecording(e, id) {
            console.log("start rec")
            navigator.mediaDevices.getUserMedia({
                audio: true
            }).then(stream => {
                recorder = new MediaRecorder(stream);
                EVENTS.forEach(name => {
                    recorder.addEventListener(name, changeState.bind(null, name, id));
                });

                recorder.addEventListener("audio", (event) => saveAudio(event, id));
                recorder.start();
            });
        }

        function stopRecording() {
            recorder.stop();
            recorder.stream.getTracks()[0].stop();
            stop.blur();
        }

        function pauseRecording() {
            recorder.pause();
            pause.blur();
        }

        function resumeRecording() {
            recorder.resume();
            resume.blur();
        }

        function saveAudio(e) {
            list = document.getElementById("list");
            let li = document.createElement("li");
            let audio = document.createElement("audio");
            audio.controls = true;
            audio.src = URL.createObjectURL(e.data);
            li.appendChild(audio);
            list.appendChild(li);
            $('#recordingsList').html(li);
            var filename = new Date().toISOString();

            records = {
                blob: e.data,
                filename: filename,
                is_record: 1
            };


        }

        function changeState(eventName) {
            record = document.getElementById("record");

            resume = document.getElementById("resume");
            pause = document.getElementById("pause");
            stop = document.getElementById("stop");
            let li = document.createElement("li");
            if (eventName === "start") {}
            if (recorder.state === "recording") {
                record.disabled = true;
                resume.disabled = true;
                pause.disabled = false;
                stop.disabled = false;
            } else if (recorder.state === "paused") {
                record.disabled = true;
                resume.disabled = false;
                pause.disabled = true;
                stop.disabled = false;
            } else if (recorder.state === "inactive") {
                record.disabled = false;
                resume.disabled = true;
                pause.disabled = true;
                stop.disabled = true;
            }
        }

        let mainblob = '';
        let mainfilename = '';

        function saveAudioDisabled(e) {
            $('#recordingsList').html('');
            var url = URL.createObjectURL(e.data);
            var au = document.createElement('audio');
            var li = document.createElement('div');
            var link = document.createElement('a');
            var filename = new Date().toISOString();
            au.controls = true;
            au.src = url;
            link.href = url;
            link.download = filename + ".wav";
            li.appendChild(au);
            li.appendChild(link);
            mainblob = e.data;
            mainfilename = filename;

            records = {
                blob: e.data,
                filename: filename,
                is_record: 1
            };

            li.appendChild(document.createTextNode(" "));
            $('#recordingsList').html(li);
        }
        // END Copy AS IT IS




        $('#Add_Record_Form').on('submit', function(e) {
            e.preventDefault();

            let fd = new FormData($('#Add_Record_Form')[0]);

            fd.append("file", records.blob, records.filename);

            $.ajax({
                type: 'post',
                url: '{{ url('store-record') }}',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,

                success: function(data) {

                    if (data.status == 200) {
                        alert(data.message);
                    } else {
                        alert('Wrong');
                    }

                },
                error: function(data) {

                    swal({
                        icon: "error",
                        text: "something went wrong",
                    });

                }
            });

        });
    </script>
@endsection
