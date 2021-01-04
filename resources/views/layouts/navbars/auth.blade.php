<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="http://si.fti.unand.ac.id/" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="{{ asset('paper') }}/img/favicon.png">
            </div>
        </a>
        <a href="http://si.fti.unand.ac.id/" class="simple-text logo-normal">
            {{ __('SIP JSI UNAND') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'dashboard') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'profile' ? 'active' : '' }}">
                <a href="{{ route('profile.edit') }}">
                    <i class="nc-icon nc-single-02"></i>
                    <p>{{ __(' User Profile ') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
