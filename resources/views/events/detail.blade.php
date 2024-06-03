@include('layout.header')
@include('layout.nav')

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{route("admin.event.index")}}">Manage Events</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>{{$event->name}}</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="{{route("admin.event.detail", $event->id)}}">Overview</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Reports</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item"><a class="nav-link" href="{{route("admin.report.index")}}">Room capacity</a></li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="border-bottom mb-3 pt-3 pb-2 event-title">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">{{ $event->name }}</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="events/edit.html" class="btn btn-sm btn-outline-secondary">Edit event</a>
                        </div>
                    </div>
                </div>
                <span class="h6">{{$event->date}}</span>
            </div>

            <!-- Tickets -->
            <div id="tickets" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Tickets</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="tickets/create.html" class="btn btn-sm btn-outline-secondary">
                                Create new ticket
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row tickets">
                @foreach($event->tickets as $ticket)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{$ticket->name}}</h5>
                            <p class="card-text">{{$ticket->cost}}</p>
                            @if($ticket->getDetailSpecailValidity() === null)
                                <p class="card-text">&nbsp;</p>
                            @elseif($ticket->getDetailSpecailValidity()["type"] === "amount")
                                <p class="card-text">{{$ticket->getDetailSpecailValidity()["value"]}} tickets available</p>
                            @elseif($ticket->getDetailSpecailValidity()["type"] === "date")
                                <p class="card-text">Available until {{$ticket->getDetailSpecailValidity()["date"]}}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Sessions -->
            <div id="sessions" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Sessions</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="sessions/create.html" class="btn btn-sm btn-outline-secondary">
                                Create new session
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive sessions">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Time</th>
                        <th>Type</th>
                        <th class="w-100">Title</th>
                        <th>Speaker</th>
                        <th>Channel</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($event->channels as $channel)
                            @foreach($channel->rooms as $room)
                                @foreach($room->programs as $program)
                                <tr>
                                    <td class="text-nowrap">{{date("H:i", strToTime($program->start))}} - {{date("H:i", strToTime($program->end))}}</td>
                                    <td>{{$program->type}}</td>
                                    <td><a href="sessions/edit.html">{{ $program->title }}</a></td>
                                    <td class="text-nowrap">{{$program->speaker}}</td>
                                    <td class="text-nowrap">{{$channel->name}} / {{ $room->name }}</td>
                                </tr>
                                @endforeach
                            @endforeach
                    @endforeach
                    <tr>
                        <td class="text-nowrap">10:15 - 11:00</td>
                        <td>Talk</td>
                        <td><a href="sessions/edit.html">What's new in X?</a></td>
                        <td class="text-nowrap">Another person</td>
                        <td class="text-nowrap">Main / Room A</td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">10:15 - 11:00</td>
                        <td>Workshop</td>
                        <td><a href="sessions/edit.html">Hands-on with Y</a></td>
                        <td class="text-nowrap">Another person</td>
                        <td class="text-nowrap">Side / Room C</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Channels -->
            <div id="channels" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Channels</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="channels/create.html" class="btn btn-sm btn-outline-secondary">
                                Create new channel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row channels">
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Main</h5>
                            <p class="card-text">3 sessions, 1 room</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Side</h5>
                            <p class="card-text">15 sessions, 2 rooms</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rooms -->
            <div id="rooms" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Rooms</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="rooms/create.html" class="btn btn-sm btn-outline-secondary">
                                Create new room
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive rooms">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Capacity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Room A</td>
                        <td>1,000</td>
                    </tr>
                    <tr>
                        <td>Room B</td>
                        <td>100</td>
                    </tr>
                    <tr>
                        <td>Room C</td>
                        <td>100</td>
                    </tr>
                    <tr>
                        <td>Room D</td>
                        <td>250</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

@include('layout.footer')