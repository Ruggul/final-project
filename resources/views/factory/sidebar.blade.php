<div class="sidebar">
    <div class="sidebar-header">
        <h3>TradeGate</h3>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>

        <!-- Inventory Management -->
        <li class="nav-item">
            <a class="nav-link {{ Request::is('inventory*') ? 'active' : '' }}" href="{{ route('inventory.index') }}">
                <i class="fas fa-boxes"></i> Inventory Management
            </a>
        </li>

        <!-- Factory Account Management -->
        <li class="nav-item">
            <a class="nav-link {{ Request::is('factory-account*') ? 'active' : '' }}" 
               data-bs-toggle="collapse" 
               href="#accountSubmenu">
                <i class="fas fa-file-invoice"></i> Factory Account
            </a>
            <div class="collapse {{ Request::is('factory-account*') ? 'show' : '' }}" id="accountSubmenu">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('payment.history') }}">Payment History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('documents.index') }}">Documents</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>