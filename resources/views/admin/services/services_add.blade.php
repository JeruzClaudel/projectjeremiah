@vite('resources/css/style1.css')
<x-app-layout>
        <div class="top-bar">
            <a class="top-button back" href="{{ route('admin.services.dashboard') }}">&larr; BACK</a>
            <h2 class="navigation-title">Add Services</h2>
        </div>
        <div class="nav-line-separator"></div>
        <div class="pane">
            <div class="right-side">
                <form action="{{ route('admin.services.store') }}" method="POST" class="form-example">
                    @csrf
                    <div class="data-info-pane">
                        <div class="information name">
                            <label class="type" for="name">SERVICE NAME</label>
                            <input type="text" id="name" name="name" class="content"/>
                        </div>
                        <div class="information">
                            <label class="type" for="description">DESCRIPTION</label>
                            <textarea id="description" name="description" class="content" rows="4" style="width: 100%; padding: 10px;"></textarea>
                        </div>


                        <div class="information">
                            <label class="type" for="consultations_id">CONSULTATION LINK</label>
                            <select id="consultations_id" name="consultations_id" class="content">
                                <option value="">-- None --</option>
                                @foreach ($consultations as $consultation)
                                    <option value="{{ $consultation->id }}" {{ old('consultations_id', $yourModel->consultations_id ?? '') == $consultation->id ? 'selected' : '' }}>
                                        {{ $consultation->title ??  $consultation->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input class="add-button" type="submit" value="CONFIRM" />
                </form>
            </div>
        </div>
</x-app-layout>
