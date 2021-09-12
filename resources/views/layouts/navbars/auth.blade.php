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
            <li class="{{ $elementActive == 'home' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'home') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Home') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                <a href="{{ route('user.index') }}">
                    <i class="nc-icon nc-single-02"></i>
                    <p>{{ __(' User Management ') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'period' ? 'active' : '' }}">
                <a href="{{ route('period.index') }}">
                    <i class="nc-icon nc-calendar-60"></i>
                    <p>{{ __(' Period Management') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'course' ? 'active' : '' }}">
                <a href="{{ route('course.index') }}">
                    <i class="nc-icon nc-book-bookmark"></i>
                    <p>{{ __(' Course Management') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'classroom' ? 'active' : '' }}">
                <a href="{{ route('classroom.index') }}">
                    <i class="nc-icon nc-hat-3"></i>
                    <p>{{ __(' Class Management ') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'profile' ? 'active' : '' }}">
                <a href="{{ route('profile.edit') }}">
                    <i class="nc-icon nc-circle-10"></i>
                    <p>{{ __(' User Profile ') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
