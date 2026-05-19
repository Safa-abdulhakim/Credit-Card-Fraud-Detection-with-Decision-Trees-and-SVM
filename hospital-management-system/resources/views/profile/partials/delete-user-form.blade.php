<p class="text-muted small mb-3">بمجرد حذف حسابك، ستُحذف جميع بياناته بشكل دائم ولا يمكن التراجع عن ذلك.</p>
<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
    <i class="fas fa-trash ms-2"></i>حذف حسابي
</button>

<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf @method('delete')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">تأكيد حذف الحساب</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من رغبتك في حذف حسابك؟ لا يمكن التراجع عن هذا الإجراء.</p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">أدخل كلمة المرور للتأكيد</label>
                        <input type="password" name="password" class="form-control @error('password','userDeletion') is-invalid @enderror"
                            placeholder="كلمة المرور" required>
                        @error('password', 'userDeletion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash ms-2"></i>حذف الحساب</button>
                </div>
            </form>
        </div>
    </div>
</div>
