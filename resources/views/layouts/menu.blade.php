<nav class="navbar navbar-expand-lg navbar-light  mb-4" style="background-color:  #808080;">
  <div class="container">
  <img class="image" src="{{url('images/newlogo.png')}}" style="float: left;"
 width="400" alt="">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                                
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        <li class="nav-item">
                                  <?php
                                    $pesanan_utama = \App\Models\Pesanan::where('user_id',Auth::user()->id)->where('status',0)->first();
                                    $notif = null;
                                    if($pesanan_utama !== null){               
                                        $notif = \App\Models\PesananDetail::where('pesanan_id', $pesanan_utama->id)->count();
                                    }

                                  ?>
                                    <a class="nav-link" href="{{ url('check_out') }}"><i class="fa fa-shopping-cart" style="color: #FFFFFF;"></i>
                                    <span class="badge badge-danger">{{ $notif }}</span>
                                    </a>
                                </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="color: #FFFFFF;">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                     <a class="dropdown-item" href="{{ url('profile') }}">
                                        Profile
                                    </a>
                                     <a class="dropdown-item" href="{{ url('history') }}">
                                        Riwayat Pemesanan
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
    </div>
  </div>
</nav>
