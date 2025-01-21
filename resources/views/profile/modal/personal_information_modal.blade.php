
<div id="personalInformationModal" class="modal">
    <div class="modal-personal-contact">
        <div class="close">
            <button type="button" onclick="closeModal('personalInformationModal')" aria-label="close the modal" title="close"></button>
        </div>
        <center><h2>Personal Information</h2></center><br>
        <form id="PersonalInformationForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <label class="motion">Name</label>
            <input title="User Name" type="text" name="name" value="{{$user->name}}">
            <label class="motion">Email</label>
            <input title="Email" type="email" name="email" value="{{$user->email}}">
            <label class="motion">Bio</label>
            <input title="Bio" type="text" name="bio" value="{{$user->bio}}">
            <label class="motion">Gender</label>
            <select title="Gender" name="user_gender" id="genderDropdown" onchange="handleGenderDropdownChange()">
                <option value="Male" {{ $user->user_gender === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $user->user_gender === 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Prefer not to say" {{ $user->user_gender === 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say</option>
                <option value="Other" {{ !in_array($user->user_gender, ['Male', 'Female', 'Prefer not to say']) ? 'selected' : '' }}>Other</option>
            </select>
            <input title="Gender" type="text" name="user_gender" id="customGenderInput" value="{{ !in_array($user->user_gender, ['Male', 'Female', 'Prefer not to say']) ? $user->user_gender : '' }}" style="{{ in_array($user->user_gender, ['Male', 'Female', 'Prefer not to say']) ? 'display:none;' : 'display:block;' }}">
            <label class="motion">Birth Date</label>
            <input title="Birth Date" type="date" name="birth_date" value="{{ $user->birth_date }}">
            <div class="save_cancel">
                <button type="submit" class="save">Save</button>
                <button class="cancel" type="button" onclick="closeModal('personalInformationModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>
