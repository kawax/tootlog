@extends('layouts.app')

@section('title', 'How to Use' . ' - ' . config('app.name', 'tootlog'))

@section('content')
    <div class="container">
        <div class="row">

            <div class="col">

                <div class="card my-5">
                    <div class="card-body">
                        <h1>How to Use</h1>

                        <p>This is based on May 2017, so detailed design may change in the future.</p>

                        <h2>User Registration</h2>

                        <p>Go to the registration page from <code>Register</code>.</p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_1.png') }}"
                                 height="365"
                                 width="800">
                        </p>

                        <ul>
                            <li>Name: Username. Only alphanumeric characters and <code>_</code> <code>-</code> can be used. Cannot be changed later as it becomes part of the URL.</li>
                            <li>E-Mail Address: Email (Gmail recommended)</li>
                            <li>Password: Password (6+ characters)</li>
                            <li>Confirm Password: Confirmation password. Enter the same password as above.</li>
                        </ul>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_2.png') }}"
                                 height="433"
                                 width="800">
                        </p>

                        <p>&nbsp;</p>

                        <p>If you get any errors, go back and reload the browser once before trying again.</p>

                        <p>&nbsp;</p>

                        <p>No email is sent during registration. You can register with an invalid email address, but you won't be able to reset your password or export CSV files. (Email verification is required before CSV export.)</p>

                        <h2>Home Screen After Registration</h2>

                        <p>There's nothing here, so first add a Mastodon account.</p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_3.png') }}"
                                 height="367"
                                 width="800">
                        </p>

                        <h2>Adding Account</h2>

                        <p>Enter a URL like <code>https://mstdn.jp/</code>.<br/>
                            Strictly speaking, we only look at the <code>https</code> part and domain, so URLs like <code>https://mstdn.jp/web/getting-started</code> work fine too.
                        </p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_4.png') }}"
                                 height="340"
                                 width="742">
                        </p>

                        <h2>Authentication</h2>

                        <p>You'll be redirected to the remote server where an OAuth authentication screen appears, so click <code>Authorize</code>.</p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_5.png') }}"
                                 height="475"
                                 width="800">
                        </p>

                        <p>&nbsp;</p>

                        <p>Return to tootlog and if logs are being retrieved, it's successful.</p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_6.png') }}"
                                 height="352"
                                 width="800">
                        </p>

                        <p>&nbsp;</p>

                        <ul>
                            <li>Initially, only up to 40 items can be retrieved.</li>
                            <li>Note that unlike Twitter, the "read account data" permission alone can read DMs. tootlog discards all DMs.</li>
                        </ul>

                        <h2>That's it</h2>

                        <p>Just wait for automatic retrieval.</p>

                        <p>&nbsp;</p>

                        <p><code>https://tootlog.net/@{user}</code> is the public URL, so use this when sharing with others.<br/>
                            Example: <a href="{{ url('/@tootlog') }}">{{ url('/@tootlog') }}</a></p>

                        <h2>Frequently Asked Questions</h2>

                        <h3>Why not allow registration by just logging in with a Mastodon account?</h3>

                        <p>
                            Because Mastodon instances are expected to disappear easily. Many have already disappeared in just one year. If an instance disappears, you can never log in again. If users register with email and link multiple Mastodon accounts to it, even if an instance disappears, there's no impact. You just can't retrieve data from it anymore.
                        </p>

                        <h3>Forgot password</h3>

                        <p>Enter your email address here and a password reset email will be sent.<br/>
                            <a href="{{ url('/password/reset') }}">{{ url('/password/reset') }}</a></p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_9.png') }}"
                                 height="233"
                                 width="800">
                        </p>

                        <h3>Font is too thin and hard to read</h3>

                        <p>You can change to a normal font from user settings.<br/>
                            <a class="uri" href="{{ url('/preferences') }}">{{ url('/preferences') }}</a>
                        </p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_10.png') }}"
                                 height="303"
                                 width="800">
                        </p>

                        <h3>Want to backup logs</h3>

                        <p>CSV export will send a CSV file to your registered email.</p>

                        <h3>Deleted on Mastodon but not gone from tootlog</h3>

                        <p>Use the Hide button to hide individual posts.<br/>
                            To hide an entire account, make the account private on the Mastodon side. It will be reflected and become private on the next update.</p>

                        <h3>Updates have stopped</h3>

                        <p>If the server is down and connection failures continue, updates will stop. Or if the token becomes invalid for some reason, it can't update. In either case, re-adding the account will resume updates.</p>

                        <h3>Want to stop log saving</h3>

                        <p>Go to Mastodon settings &rarr; Authorized apps and "Revoke".</p>

                        <h3>Want to delete account</h3>

                        <p>You can delete individual Mastodon accounts. From the individual profile page, click Delete... All data will be deleted, so export is recommended beforehand.</p>

                        <h3>Timeline is...</h3>

                        <p>Timeline is an experimental feature, so there's not much support for detailed aspects.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection