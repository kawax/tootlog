@extends('layouts.app')

@section('title', '使い方' . ' - ' . config('app.name', 'tootlog'))

@section('content')
    <div class="container">
        <div class="row">

            <div class="col">

                <div class="card my-5">
                    <div class="card-body">
                        <h1>使い方</h1>

                        <p>2017年5月時点のものなので細かいデザインは今後変わる可能性があります。</p>

                        <h2>ユーザー登録</h2>

                        <p><code>Register</code>から登録ページに行きます。</p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_1.png') }}"
                                 height="365"
                                 width="800">
                        </p>

                        <p>&nbsp;</p>

                        <ul>
                            <li>Name: ユーザー名。英数字と<code>_</code> <code>-</code>のみ使用可。URLの一部なので後から変更できません。</li>
                            <li>E-Mail Address: メール(Gmail推奨)</li>
                            <li>Password: パスワード(6文字以上)</li>
                            <li>Confirm Password: 確認用パスワード。上と同じパスワードを入力。</li>
                        </ul>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_2.png') }}"
                                 height="433"
                                 width="800">
                        </p>

                        <p>&nbsp;</p>

                        <p>なにかエラーが出た場合は戻ってブラウザを一度リロードしてからやり直してください。</p>

                        <p>&nbsp;</p>

                        <p>登録時にメールは送信されません。届かないメールで登録は可能ですがパスワード再発行やCSVエクスポートができなくなります。（CSVエクスポート前にはメールの確認が必要。）</p>

                        <h2>登録後のホーム画面</h2>

                        <p>なにもないのでまずはMastodonアカウントを追加します。</p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_3.png') }}"
                                 height="367"
                                 width="800">
                        </p>

                        <h2>アカウント追加</h2>

                        <p>URLに<code>https://mstdn.jp/</code>などを入力。<br/>
                            厳密には<code>https</code>部分とドメインだけ見てるので<code>https://mstdn.jp/web/getting-started</code>のようなURLでも大丈夫です。
                        </p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_4.png') }}"
                                 height="340"
                                 width="742">
                        </p>

                        <h2>認証</h2>

                        <p>相手サーバーに移動してOAuth認証画面が出るので<code>承認</code>します。</p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_5.png') }}"
                                 height="475"
                                 width="800">
                        </p>

                        <p>&nbsp;</p>

                        <p>tootlogに戻って来てログが取得できていれば成功です。</p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_6.png') }}"
                                 height="352"
                                 width="800">
                        </p>

                        <p>&nbsp;</p>

                        <ul>
                            <li>初回は40件までしか取得できません。</li>
                            <li>「アカウントからのデータ読み取り」権限のみでもDMまで読めるのはTwitterとは違う所なので注意。tootlogではDMはすべて捨てています。</li>
                        </ul>

                        <h2>終わり</h2>

                        <p>後は自動で取得されるのを待つだけです。</p>

                        <p>&nbsp;</p>

                        <p><code>https://tootlog.net/@{user}</code>が公開用URLなので人に教える時はこれを教えます。<br/>
                            例：<a class="uri" href="{{ url('/@tootlog') }}">{{ url('/@tootlog') }}</a></p>

                        <h2>よくあるかもしれない質問</h2>

                        <h3>マストドンアカウントでログインするだけで登録可能にしない理由は？</h3>

                        <p>
                            マストドンのインスタンスは簡単に消える前提だからです。1年ですでに大量に消えてる。インスタンスが消えた場合二度とログインできなくなる。メールでユーザー登録してそこに複数のマストドンアカウントを紐付ける形ならインスタンスが消えても影響はない。単に取得できなくなるだけ。
                        </p>

                        <h3>パスワードを忘れた</h3>

                        <p>ここでメールアドレスを入力すれば再発行のためのメールが送信されます。<br/>
                            <a class="uri"
                               href="{{ url('/password/reset') }}">{{ url('/password/reset') }}</a></p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_9.png') }}"
                                 height="233"
                                 width="800">
                        </p>

                        <h3>フォントが細くて読みにくい</h3>

                        <p>ユーザー設定からノーマルなフォントに変更できます。<br/>
                            <a class="uri" href="{{ url('/preferences') }}">{{ url('/preferences') }}</a>
                        </p>

                        <p>
                            <img alt=""
                                 src="{{ asset('images/tootlog_10.png') }}"
                                 height="303"
                                 width="800">
                        </p>

                        <h3>ログをバックアップしたい</h3>

                        <p>CSVエクスポートでCSVファイルとして登録メールに送信されます。</p>

                        <h3 id="mastodontootlog">Mastodonで削除してもtootlogで消えてない</h3>

                        <p>Hideボタンで個別に非表示にしてください。<br/>
                            アカウント単位で非表示にするにはMastodon側で非公開アカウントにします。次の更新時に反映されて非公開になります。</p>

                        <h3>更新されなくなってる</h3>

                        <p>サーバーが落ちてて接続失敗が続くと更新されなくなります。もしくはなんらかの理由でtokenが無効になると更新できません。どちらの場合もアカウント追加をやり直すと更新再開されます。</p>

                        <h3>ログ保存を解除したい</h3>

                        <p>Mastodon側の設定&rarr;認証済みアプリで「取消」してください。</p>

                        <h3>tootlogのアカウントを削除したい</h3>

                        <p>削除機能はまだありません。非公開にしたい場合はMastodon側で非公開アカウントにしてください。</p>

                        <h3>タイムラインが&hellip;</h3>

                        <p>タイムラインは実験的な機能なので細かい部分への対応はあまりありません。</p>

                        <h3>日本語化してほしい</h3>

                        <p>ユーザーが増えたら検討。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
