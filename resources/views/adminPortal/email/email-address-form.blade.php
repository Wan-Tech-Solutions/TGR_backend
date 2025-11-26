@include('adminPortal.layout.header')

<div class="container-fluid">
    <div class="page-inner">
        {{-- Title Section --}}
        <div class="page-header">
            <h4 class="page-title">{{ isset($emailAddress) ? 'Edit' : 'Add' }} Email Address</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="fas fa-chevron-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.email-addresses.index') }}">Email Addresses</a>
                </li>
                <li class="separator">
                    <i class="fas fa-chevron-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ isset($emailAddress) ? 'Edit' : 'Add' }}</a>
                </li>
            </ul>
        </div>

        {{-- Alert Messages --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Validation Errors!</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ isset($emailAddress) ? 'Edit' : 'Add New' }} Email Address</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" 
                              action="{{ isset($emailAddress) ? route('admin.email-addresses.update', $emailAddress) : route('admin.email-addresses.store') }}">
                            @csrf
                            @if(isset($emailAddress))
                                @method('PUT')
                            @endif

                            {{-- Basic Information --}}
                            <fieldset class="mb-4">
                                <legend class="fs-5 fw-bold mb-3">Basic Information</legend>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" 
                                           value="{{ old('email', $emailAddress->email ?? '') }}" 
                                           required>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="label" class="form-label">Label <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('label') is-invalid @enderror" 
                                           id="label" name="label" 
                                           placeholder="e.g., Primary, Support, Investors"
                                           value="{{ old('label', $emailAddress->label ?? '') }}" 
                                           required>
                                    @error('label')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <small class="form-text text-muted">A descriptive name for this email address</small>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3"
                                              placeholder="Optional description for this email address">{{ old('description', $emailAddress->description ?? '') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </fieldset>

                            {{-- IMAP/POP3 Configuration --}}
                            <fieldset class="mb-4">
                                <legend class="fs-5 fw-bold mb-3">IMAP/POP3 Configuration <small class="text-muted">(Optional)</small></legend>

                                <div class="mb-3">
                                    <label for="host" class="form-label">Mail Server Host</label>
                                    <input type="text" class="form-control @error('host') is-invalid @enderror" 
                                           id="host" name="host" 
                                           placeholder="e.g., imap.gmail.com"
                                           value="{{ old('host', $emailAddress->host ?? '') }}">
                                    @error('host')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <small class="form-text text-muted">IMAP or POP3 server address</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="port" class="form-label">Port</label>
                                            <input type="number" class="form-control @error('port') is-invalid @enderror" 
                                                   id="port" name="port" 
                                                   placeholder="e.g., 993"
                                                   value="{{ old('port', $emailAddress->port ?? '') }}"
                                                   min="1" max="65535">
                                            @error('port')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                            <small class="form-text text-muted">IMAP: 993 (SSL), 143 (TLS) | POP3: 995 (SSL), 110 (TLS)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="encryption" class="form-label">Encryption</label>
                                            <select class="form-select @error('encryption') is-invalid @enderror" 
                                                    id="encryption" name="encryption">
                                                <option value="">-- Select Encryption --</option>
                                                <option value="ssl" {{ old('encryption', $emailAddress->encryption ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                                                <option value="tls" {{ old('encryption', $emailAddress->encryption ?? '') === 'tls' ? 'selected' : '' }}>TLS</option>
                                                <option value="none" {{ old('encryption', $emailAddress->encryption ?? '') === 'none' ? 'selected' : '' }}>None</option>
                                            </select>
                                            @error('encryption')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" 
                                           placeholder="Enter password for this email account"
                                           value="">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <small class="form-text text-muted">Password will be encrypted. Leave empty to keep existing password.</small>
                                </div>
                            </fieldset>

                            {{-- Status & Sync Options --}}
                            <fieldset class="mb-4">
                                <legend class="fs-5 fw-bold mb-3">Options</legend>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" 
                                           name="is_active" value="1"
                                           {{ old('is_active', isset($emailAddress) ? $emailAddress->is_active : true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        <strong>Active</strong>
                                        <small class="text-muted d-block">This email address will receive incoming messages</small>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="auto_sync" 
                                           name="auto_sync" value="1"
                                           {{ old('auto_sync', isset($emailAddress) ? $emailAddress->auto_sync : false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="auto_sync">
                                        <strong>Enable Auto-Sync</strong>
                                        <small class="text-muted d-block">Automatically sync emails from this account (requires IMAP/POP3 setup)</small>
                                    </label>
                                </div>
                            </fieldset>

                            {{-- Form Actions --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ isset($emailAddress) ? 'Update' : 'Add' }} Email Address
                                </button>
                                <a href="{{ route('admin.email-addresses.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Info Sidebar --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-3">
                            <strong><i class="fas fa-info-circle"></i> Setup Guide</strong>
                            <hr>
                            <p class="mb-2"><strong>Quick Setup:</strong></p>
                            <ul class="mb-3">
                                <li>Enter the email address</li>
                                <li>Add a descriptive label</li>
                                <li>Click Save</li>
                            </ul>
                            
                            <p class="mb-2"><strong>IMAP/POP3 Setup (Optional):</strong></p>
                            <ul class="mb-0">
                                <li>Provide mail server details</li>
                                <li>Set appropriate port & encryption</li>
                                <li>Enable auto-sync to automatically import emails</li>
                            </ul>
                        </div>

                        <div class="alert alert-success">
                            <strong><i class="fas fa-lightbulb"></i> Tips</strong>
                            <hr>
                            <ul class="mb-0 small">
                                <li>Add multiple email addresses to monitor</li>
                                <li>Label them for easy identification</li>
                                <li>Use auto-sync for automatic email import</li>
                                <li>Inactive addresses won't receive emails</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('adminPortal.layout.footer')
