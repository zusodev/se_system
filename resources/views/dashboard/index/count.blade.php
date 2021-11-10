<div class="row">
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-75">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">
                    <h5>
                        部門：
                        <a class="text-white" href="{{ route("target_departments.index") }}">{{ $groupsCount }}</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-warning o-hidden h-75">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5">
                    <h5>
                        目標使用者：
                        <a class="text-white" href="{{ route("target_users.index") }}">{{ $usersCount }}</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-75">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                </div>
                <div class="mr-5">
                    <h5>
                        排程：
                        <a class="text-white" href="{{ route("target_users.index") }}">{{ $jobsCount }}</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-danger o-hidden h-75">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fas fa-fw fa-life-ring"></i>
                </div>
                <div class="mr-5">
                    <h5>
                        總寄信量：{{ $logsCount }}
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
