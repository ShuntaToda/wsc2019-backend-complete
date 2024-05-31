@include("layout.header")

<div class="container-fluid">
    <div class="row">
        <main class="col-md-6 mx-sm-auto px-4">
            <div class="pt-3 pb-2 mb-3 border-bottom text-center">
                <h1 class="h2">WorldSkills Event Platform</h1>
            </div>
            
            <form class="form-signin" action="{{route("login")}}" method="POST">
                @csrf
                <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

                <label for="inputEmail" class="sr-only">Email</label>
                <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" autofocus>

                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password">
                <button class="btn btn-lg btn-primary btn-block" id="login" type="submit">Sign in</button>
                {{-- @if($errors->has("password") || $errors->has("email"))
                    <p>Email or password not correct</p>
                @endif --}}
                @if($errors->any())
                    <p>Email or password not correct</p>
                @endif
            </form>

        </main>
    </div>
</div>
@include("layout.footer")