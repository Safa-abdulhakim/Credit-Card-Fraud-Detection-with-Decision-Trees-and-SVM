<p class="text-muted small mb-3">Once your account is deleted, all data will be permanently removed.</p>
<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
    <i class="fas fa-trash me-2"></i>Delete My Account
</button>

<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf @method('delete')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirm Account Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Enter your password to confirm</label>
                        <input type="password" name="password" class="form-control @error('password','userDeletion') is-invalid @enderror"
                            placeholder="Your password" required>
                        @error('password', 'userDeletion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash me-2"></i>Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
