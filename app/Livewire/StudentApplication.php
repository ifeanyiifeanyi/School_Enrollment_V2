<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Department;
use App\Models\Application;
use App\Models\ExamSubject;
use Illuminate\Support\Str;
use GuzzleHttp\Psr7\Request;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Jobs\ProcessRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmationMail;

class StudentApplication extends Component
{
    use WithFileUploads;

    public $totalSteps = 5;
    public $currentStep = 1;

    public $first_name;
    public $last_name;
    public $other_names;
    public $email;
    public $phone;
    public $gender;
    public $religion;
    public $dob;
    public $nin;
    public $current_residence_address;
    public $permanent_residence_address;
    public $guardian_name;
    public $guardian_phone_number;
    public $guardian_address;
    public $secondary_school_attended;
    public $secondary_school_graduation_year;
    public $secondary_school_certificate_type;
    public $jamb_reg_no;
    public $jamb_score;
    public $department_id;
    public $document_medical_report;
    public $document_birth_certificate;
    public $document_local_government_identification;
    public $document_secondary_school_certificate_type;
    public $passport_photo;
    public $terms;
    public $blood_group;
    public $genotype;


    public $department_description;


    public $examSubjects;
    public $countries = [];


    public $country;
    public $state;
    public $localGovernment;
    public $states = [];
    public $localGovernments = [];
    public $userId;


    public $sittings = 1;
    public $examBoard1 = 'waec';
    public $examBoard2 = 'waec';
    public $subjects1 = [];
    public $subjects2 = [];
    public $showSecondSitting = false;


    public function mount()
    {

        $user = User::with('student')->find(auth()->user()->id);
        $this->examSubjects = ExamSubject::pluck('name', 'name');

        // Load countries from JSON and extract names
        $path = public_path('countries.json');
        if (File::exists($path)) {
            $json = File::get($path);
            $countriesData = json_decode($json, true);
            $this->countries = array_map(function ($country) {
                return $country['name'];
            }, $countriesData);
        } else {
            $this->countries = []; // Ensure the countries array is always initialized
        }

        $this->userId = $user->id;
        $this->first_name = old('first_name') ?? ($user ? $user->first_name : null);

        $this->blood_group = old('blood_group') ?? ($user ? $user->blood_group : null);
        $this->genotype = old('genotype') ?? ($user ? $user->genotype : null);



        $this->last_name = old('last_name') ?? ($user ? $user->last_name : null);

        $this->other_names = old('other_names') ?? ($user ? $user->other_names : null);

        $this->email = old('email') ?? ($user ? $user->email : null);

        $this->phone = old('phone') ?? ($user->student ? $user->student->phone : null);

        $this->state = old('state') ?? ($user->student ? $user->student->state_of_origin : null);

        $this->country = old('country') ?? ($user->student ? $user->student->country_of_origin : null);
        $this->localGovernment = old('localGovernment') ?? ($user->student ? $user->student->lga_origin : null);

        $this->religion = old('religion') ?? ($user->student ? $user->student->religion : null);

        $this->dob = old('dob') ?? ($user->student ? $user->student->dob : null);

        $this->nin = old('nin') ?? ($user->student ? $user->student->nin : null);

        $this->current_residence_address = old('current_residence_address') ?? ($user->student ? $user->student->current_residence_address : null);

        $this->permanent_residence_address = old('permanent_residence_address') ?? ($user->student ? $user->student->permanent_residence_address : null);

        $this->guardian_name = old('guardian_name') ?? ($user->student ? $user->student->guardian_name : null);

        $this->guardian_phone_number = old('guardian_phone_number') ?? ($user->student ? $user->student->guardian_phone_number : null);

        $this->guardian_address = old('guardian_address') ?? ($user->student ? $user->student->guardian_address : null);

        $this->secondary_school_attended = old('secondary_school_attended') ?? ($user->student ? $user->student->secondary_school_attended : null);

        $this->secondary_school_graduation_year = old('secondary_school_graduation_year') ?? ($user->student ? $user->student->secondary_school_graduation_year : null);

        $this->secondary_school_certificate_type = old('secondary_school_certificate_type') ?? ($user->student ? $user->student->secondary_school_certificate_type : null);

        $this->jamb_reg_no = old('jamb_reg_no') ?? ($user->student ? $user->student->jamb_reg_no : null);

        $this->jamb_score = old('jamb_score') ?? ($user->student ? $user->student->jamb_score : null);

        $this->department_id = old('department_id') ?? ($user->student ? $user->student->department_id : null);

        $this->passport_photo = old('passport_photo') ?? ($user->student ? $user->student->passport_photo : null);


        $this->document_birth_certificate = old('document_birth_certificate') ?? ($user->student ? $user->student->document_birth_certificate : null);

        $this->document_local_government_identification = old('document_local_government_identification') ?? ($user->student ? $user->student->document_local_government_identification : null);

        $this->document_secondary_school_certificate_type = old('document_secondary_school_certificate_type') ?? ($user->student ? $user->student->document_secondary_school_certificate_type : null);


        if (old('gender')) {
            $this->gender = old('gender');
        } elseif ($user->student) {
            $this->gender = $user->student->gender;
        }

        $this->religion =   old('religion') ?? ($user->student ? $user->student->religion : null);
        $this->blood_group =   old('blood_group') ?? ($user->student ? $user->student->blood_group : null);
        $this->genotype =   old('genotype') ?? ($user->student ? $user->student->genotype : null);


        $this->currentStep = 1;
    }






    public function updatedDepartmentId()
    {
        // Assuming you have a Department model with a description attribute
        $department = Department::find($this->department_id);
        $this->department_description = $department ? $department->description : '';
    }

    // validate form data
    public function validateData()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'first_name' => 'required|string',
                'blood_group' => 'required|string',
                'genotype' => 'required|string',
                'last_name' => 'required|string',
                'other_names' => 'nullable',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($this->userId, 'id'),
                ],
                'phone' => 'required',
                'gender' => 'required',
                'religion' => 'required|string',
                'dob' => 'required|date',
                'nin' => 'required',
                'current_residence_address' => 'required|string',
                'permanent_residence_address' => 'required|string',
                'guardian_name' => 'required|string',
                'guardian_phone_number' => 'required|string',
                'guardian_address' => 'required|string',
                'country' => 'required',
                'state' => 'required_if:country,Nigeria',
                'localGovernment' => 'required_if:country,Nigeria',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'secondary_school_attended' => 'required|string',
                'secondary_school_graduation_year' => 'required|date',
                'secondary_school_certificate_type' => 'required|string',
                'jamb_reg_no' => 'required|string',
                'jamb_score' => 'required|numeric',
            ]);
        } elseif ($this->currentStep == 3) {
            $this->validate([
                'department_id' => 'required',
            ], [
                'department_id.required' => 'Please select a department',
            ]);
        } elseif ($this->currentStep == 4) {
            $validationRules = [
                'sittings' => 'required|integer|in:1,2',
                'examBoard1' => 'required_if:sittings,1|in:waec,neco,gce',
                'examBoard2' => 'required_if:sittings,2|in:waec,neco,gce',
                'subjects1' => 'required|array|min:4',
                'subjects1.*' => 'required',
                'subjects1.*.subject' => 'required_with:subjects1|distinct|min:4',
                'subjects1.*.score' => 'required_with:subjects1|regex:/^[A-F][1-9]$/',
                'subjects2' => 'required_if:sittings,2|array',
                'subjects2.*' => 'required_if:sittings,2',
                'subjects2.*.subject' => 'required_with:subjects2|distinct|min:4',
                'subjects2.*.score' => 'required_with:subjects2|regex:/^[A-F][1-9]$/',
            ];

            $validationMessages = [
                'subjects1.required' => 'Please add at least one subject and score for Sitting 1.',
                'subjects2.required' => 'Please add at least one subject and score for Sitting 2.',
                'subjects1.*.subject.required' => 'The subject is required.',
                'subjects1.*.score.required' => 'The score is required.',
                'subjects1.*.score.regex' => 'The score must be in the format A1, B2, C3, ..., F9.',
                'subjects2.*.subject.required' => 'The subject is required.',
                'subjects2.*.score.required' => 'The score is required.',
                'subjects2.*.score.regex' => 'The score must be in the format A1, B2, C3, ..., F9.',
                'subjects2.*.subject.min' => 'The subjects2 field must have at least 4 items.',
            ];

            $validationAttributes = [
                'subjects1.*.subject' => 'subject',
                'subjects1.*.score' => 'score',
                'subjects2.*.subject' => 'subject',
                'subjects2.*.score' => 'score',
            ];

            $this->validate($validationRules, $validationMessages, $validationAttributes);
        }
    }



    public function decreaseStep()
    {
        $this->resetErrorBag();
        $this->currentStep--;
        if ($this->currentStep < 1) {
            $this->currentStep = 1;
        }
    }

    public function increaseStep()
    {
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;
        if ($this->currentStep > $this->totalSteps) {
            $this->currentStep = $this->totalSteps;
        }
    }



    public function render()
    {

        $departments = Department::all();
        return view('livewire.student-application', [
            'departments' => $departments,
            'examSubjects' => $this->examSubjects,
            'countries' => $this->countries
        ]);
    }

    public function updatedSittings($value)
    {
        $this->showSecondSitting = $value === 2;

        if ($value === 1) {
            $this->subjects2 = [];
        } elseif ($value === 2) {
            $this->subjects1 = [];
        }
    }


    public function addSubject($index)
    {
        if ($index === 1) {
            $this->subjects1[] = ['subject' => '', 'score' => ''];
        } elseif ($index === 2) {
            $this->subjects2[] = ['subject' => '', 'score' => ''];
        }
    }

    public function removeSubject($index, $key)
    {
        if ($index === 1) {
            unset($this->subjects1[$key]);
            $this->subjects1 = array_values($this->subjects1);
        } elseif ($index === 2) {
            unset($this->subjects2[$key]);
            $this->subjects2 = array_values($this->subjects2);
        }
    }



    public function updatedCountry($value)
    {
        $this->resetStateAndLocalGovernment();

        if ($value === 'Nigeria') {
            $this->states = $this->getNigerianStates();
        }
    }



    public function updatedState($value)
    {
        if (!empty($value)) {
            $this->localGovernments = $this->getLocalGovernmentsByState($value);
        } else {
            $this->localGovernments = [];
        }
    }


    protected function resetStateAndLocalGovernment()
    {
        $this->state = null;
        $this->localGovernment = null;
        $this->states = [];
        $this->localGovernments = [];
    }

    protected function getNigerianStates()
    {
        // Return an array of Nigerian states
        return [
            'Abia', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno', 'Cross River', 'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'Gombe', 'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara',
        ];
    }

    protected function getLocalGovernmentsByState($state)
    {
        $localGovernments = [
            'Abia' => ['Aba North', 'Aba South', 'Arochukwu', 'Bende', 'Ikwuano', 'Isiala Ngwa North', 'Isiala Ngwa South', 'Isuikwuato', 'Obi Ngwa', 'Ohafia', 'Osisioma', 'Ugwunagbo', 'Ukwa East', 'Ukwa West', 'Umuahia North', 'Umuahia South', 'Umu Nneochi'],


            'Adamawa' => ['Demsa', 'Fufure', 'Ganye', 'Girei', 'Gombi', 'Guyuk', 'Hong', 'Jada', 'Lamurde', 'Madagali', 'Maiha', 'Mayo Belwa', 'Michika', 'Mubi North', 'Mubi South', 'Numan', 'Shelleng', 'Song', 'Toungo', 'Yola North', 'Yola South'],

            'Akwa Ibom' => ['Abak', 'Eastern Obolo', 'Eket', 'Esit Eket', 'Essien Udim', 'Etim Ekpo', 'Etinan', 'Ibeno', 'Ibesikpo Asutan', 'Ibiono Ibom', 'Ika', 'Ikono', 'Ikot Abasi', 'Ikot Ekpene', 'Ini', 'Itu', 'Mbo', 'Mkpat Enin', 'Nsit Atai', 'Nsit Ibom', 'Nsit Ubium', 'Obot Akara', 'Okobo', 'Onna', 'Oron', 'Oruk Anam', 'Udung Uko', 'Ukanafun', 'Uruan', 'Urue-Offong/Oruko', 'Uyo'],


            'Anambra' => ['Aguata', 'Anambra East', 'Anambra West', 'Anaocha', 'Awka North', 'Awka South', 'Ayamelum', 'Dunukofia', 'Ekwusigo', 'Idemili North', 'Idemili South', 'Ihiala', 'Njikoka', 'Nnewi North', 'Nnewi South', 'Ogbaru', 'Onitsha North', 'Onitsha South', 'Orumba North', 'Orumba South', 'Oyi'],


            'Bauchi' => ['Alkaleri', 'Bauchi', 'Bogoro', 'Damban', 'Darazo', 'Dass', 'Gamawa', 'Ganjuwa', 'Giade', 'Itas/Gadau', 'Jama’are', 'Katagum', 'Kirfi', 'Misau', 'Ningi', 'Shira', 'Tafawa Balewa', 'Toro', 'Warji', 'Zaki'],


            'Bayelsa' => ['Brass', 'Ekeremor', 'Kolokuma/Opokuma', 'Nembe', 'Ogbia', 'Sagbama', 'Southern Ijaw', 'Yenagoa'],


            'Benue' => ['Ado', 'Agatu', 'Apa', 'Buruku', 'Gboko', 'Guma', 'Gwer East', 'Gwer West', 'Katsina-Ala', 'Konshisha', 'Kwande', 'Logo', 'Makurdi', 'Obi', 'Ogbadibo', 'Ohimini', 'Oju', 'Okpokwu', 'Otukpo', 'Tarka', 'Ukum', 'Ushongo', 'Vandeikya'],


            'Borno' => ['Abadam', 'Askira/Uba', 'Bama', 'Bayo', 'Biase', 'Chibok', 'Damboa', 'Dikwa', 'Gubio', 'Guzamala', 'Gwoza', 'Hawul', 'Jere', 'Kaga', 'Kala/Balge', 'Konduga', 'Kukawa', 'Kwaya Kusar', 'Mafa', 'Magumeri', 'Maiduguri', 'Marte', 'Mobbar', 'Monguno', 'Ngala', 'Nganzai', 'Shani'],


            'Cross River' => ['Abi', 'Akamkpa', 'Akpabuyo', 'Bakassi', 'Bekwarra', 'Biase', 'Boki', 'Calabar Municipal', 'Calabar South', 'Etung', 'Ikom', 'Obanliku', 'Obubra', 'Obudu', 'Odukpani', 'Ogoja', 'Yakurr', 'Yala'],


            'Delta' => ['Aniocha North', 'Aniocha South', 'Bomadi', 'Burutu', 'Ethiope East', 'Ethiope West', 'Ika North East', 'Ika South', 'Isoko North', 'Isoko South', 'Ndokwa East', 'Ndokwa West', 'Okpe', 'Oshimili North', 'Oshimili South', 'Patani', 'Sapele', 'Udu', 'Ughelli North', 'Ughelli South', 'Ukwuani', 'Uvwie', 'Warri North', 'Warri South', 'Warri South West'],


            'Ebonyi' => ['Abakaliki', 'Afikpo North', 'Afikpo South', 'Ebonyi', 'Ezza North', 'Ezza South', 'Ikwo', 'Ishielu', 'Ivo', 'Izzi', 'Ohaozara', 'Ohaukwu', 'Onicha'],


            'Edo' => ['Akoko-Edo', 'Egor', 'Esan Central', 'Esan North-East', 'Esan South-East', 'Esan West', 'Etsako Central', 'Etsako East', 'Etsako West', 'Igueben', 'Ikpoba Okha', 'Orhionmwon', 'Oredo', 'Ovia North-East', 'Ovia South-West', 'Owan East', 'Owan West', 'Uhunmwonde'],

            'Ekiti' => ['Ado Ekiti', 'Efon', 'Ekiti East', 'Ekiti South-West', 'Ekiti West', 'Emure', 'Gbonyin', 'Ido Osi', 'Ijero', 'Ikere', 'Ikole', 'Ilejemeje', 'Irepodun/Ifelodun', 'Ise/Orun', 'Moba', 'Oye'],

            'Enugu' => ['Aninri', 'Awgu', 'Enugu East', 'Enugu North', 'Enugu South', 'Ezeagu', 'Igbo Etiti', 'Igbo Eze North', 'Igbo Eze South', 'Isi Uzo', 'Nkanu East', 'Nkanu West', 'Nsukka', 'Oji River', 'Udenu', 'Udi', 'Uzo Uwani'],


            'Gombe' => ['Akko', 'Balanga', 'Billiri', 'Dukku', 'Funakaye', 'Gombe', 'Kaltungo', 'Kwami', 'Nafada', 'Shongom', 'Yamaltu/Deba'],

            'Imo' => ['Aboh Mbaise', 'Ahiazu Mbaise', 'Ehime Mbano', 'Ezinihitte Mbaise', 'Ideato North', 'Ideato South', 'Ihitte/Uboma', 'Ikeduru', 'Isiala Mbano', 'Isu', 'Mbaitoli', 'Ngor Okpala', 'Njaba', 'Nkwerre', 'Nwangele', 'Obowo', 'Oguta', 'Ohaji/Egbema', 'Okigwe', 'Orlu', 'Orsu', 'Oru East', 'Oru West', 'Owerri Municipal', 'Owerri North', 'Owerri West', 'Unuimo'],


            'Jigawa' => ['Auyo', 'Babura', 'Biriniwa', 'Birnin Kudu', 'Buji', 'Dutse', 'Gagarawa', 'Garki', 'Gumel', 'Guri', 'Gwaram', 'Gwiwa', 'Hadejia', 'Jahun', 'Kafin Hausa', 'Kaugama', 'Kazaure', 'Kiri Kasama', 'Kiyawa', 'Maigatari', 'Malam Madori', 'Miga', 'Ringim', 'Roni', 'Sule Tankarkar', 'Taura', 'Yankwashi'],


            'Kaduna' => ['Birnin Gwari', 'Chikun', 'Giwa', 'Igabi', 'Ikara', 'Jaba', 'Jema’a', 'Kachia', 'Kaduna North', 'Kaduna South', 'Kagarko', 'Kajuru', 'Kaura', 'Kauru', 'Kubau', 'Kudan', 'Lere', 'Makarfi', 'Sabon Gari', 'Sanga', 'Soba', 'Zangon Kataf', 'Zaria'],


            'Kano' => ['Ajingi', 'Albasu', 'Bagwai', 'Bebeji', 'Bichi', 'Bunkure', 'Dala', 'Dambatta', 'Dawakin Kudu', 'Dawakin Tofa', 'Doguwa', 'Fagge', 'Gabasawa', 'Garko', 'Garun Mallam', 'Gaya', 'Gezawa', 'Gwale', 'Gwarzo', 'Kabo', 'Kano Municipal', 'Karaye', 'Kibiya', 'Kiru', 'Kumbotso', 'Kunchi', 'Kura', 'Madobi', 'Makoda', 'Minjibir', 'Nasarawa', 'Rano', 'Rimin Gado', 'Rogo', 'Shanono', 'Sumaila', 'Takai', 'Tarauni', 'Tofa', 'Tsanyawa', 'Tudun Wada', 'Ungogo', 'Warawa', 'Wudil'],


            'Katsina' => ['Bakori', 'Batagarawa', 'Batsari', 'Baure', 'Bindawa', 'Charanchi', 'Dan Musa', 'Dandume', 'Danja', 'Daura', 'Dutsi', 'Dutsin Ma', 'Faskari', 'Funtua', 'Ingawa', 'Jibia', 'Kafur', 'Kaita', 'Kankara', 'Kankia', 'Katsina', 'Kurfi', 'Kusada', 'Mai’Adua', 'Malumfashi', 'Mani', 'Mashi', 'Matazu', 'Musawa', 'Rimi', 'Sabuwa', 'Safana', 'Sandamu', 'Zango'],


            'Kebbi' => ['Aleiro', 'Arewa Dandi', 'Argungu', 'Augie', 'Bagudo', 'Birnin Kebbi', 'Bunza', 'Dandi', 'Fakai', 'Gwandu', 'Jega', 'Kalgo', 'Koko/Besse', 'Maiyama', 'Ngaski', 'Sakaba', 'Shanga', 'Suru', 'Wasagu/Danko', 'Yauri', 'Zuru'],


            'Kogi' => ['Adavi', 'Ajaokuta', 'Ankpa', 'Bassa', 'Dekina', 'Ibaji', 'Idah', 'Igalamela Odolu', 'Ijumu', 'Ikole', 'Kabba/Bunu', 'Kogi', 'Lokoja', 'Mopa Muro', 'Ofu', 'Ogori/Magongo', 'Okehi', 'Okene', 'Olamaboro', 'Omala', 'Yagba East', 'Yagba West'],


            'Kwara' => ['Asa', 'Baruten', 'Edu', 'Ekiti', 'Ifelodun', 'Ilorin East', 'Ilorin South', 'Ilorin West', 'Irepodun', 'Isin', 'Kaiama', 'Moro', 'Offa', 'Oke Ero', 'Oyun', 'Pategi'],

            'Lagos' => ['Agege', 'Ajeromi-Ifelodun', 'Alimosho', 'Amuwo-Odofin', 'Apapa', 'Badagry', 'Epe', 'Eti Osa', 'Ibeju-Lekki', 'Ifako-Ijaiye', 'Ikeja', 'Ikorodu', 'Kosofe', 'Lagos Island', 'Lagos Mainland', 'Mushin', 'Ojo', 'Oshodi-Isolo', 'Shomolu', 'Surulere'],


            'Nasarawa' => ['Akwanga', 'Awe', 'Doma', 'Karu', 'Keana', 'Keffi', 'Kokona', 'Lafia', 'Nasarawa', 'Nasarawa Egon', 'Obi', 'Toto', 'Wamba'],


            'Niger' => ['Agaie', 'Agwara', 'Bida', 'Borgu', 'Bosso', 'Chanchaga', 'Edati', 'Gbako', 'Gurara', 'Katcha', 'Kontagora', 'Lapai', 'Lavun', 'Magama', 'Mariga', 'Mashegu', 'Mokwa', 'Munya', 'Paikoro', 'Rafi', 'Rijau', 'Shiroro', 'Suleja', 'Tafa', 'Wushishi'],


            'Ogun' => ['Abeokuta North', 'Abeokuta South', 'Ado-Odo/Ota', 'Egbado North', 'Egbado South', 'Ewekoro', 'Ifo', 'Ijebu East', 'Ijebu North', 'Ijebu North East', 'Ijebu Ode', 'Ikenne', 'Imeko Afon', 'Ipokia', 'Obafemi Owode', 'Odeda', 'Odogbolu', 'Ogun Waterside', 'Remo North', 'Sagamu', 'Yewa North', 'Yewa South'],


            'Ondo' => ['Akoko North-East', 'Akoko North-West', 'Akoko South-West', 'Akoko South-East', 'Akure North', 'Akure South', 'Ese Odo', 'Idanre', 'Ifedore', 'Ilaje', 'Ile Oluji/Okeigbo', 'Irele', 'Odigbo', 'Okitipupa', 'Ondo East', 'Ondo West', 'Ose', 'Owo'],


            'Osun' => ['Aiyedaade', 'Aiyedire', 'Atakunmosa East', 'Atakunmosa West', 'Boluwaduro', 'Boripe', 'Ede North', 'Ede South', 'Egbedore', 'Ejigbo', 'Ife Central', 'Ife East', 'Ife North', 'Ife South', 'Ifedayo', 'Ifelodun', 'Ila', 'Ilesa East', 'Ilesa West', 'Irepodun', 'Irewole', 'Isokan', 'Iwo', 'Obokun', 'Odo Otin', 'Ola Oluwa', 'Olorunda', 'Oriade', 'Orolu', 'Osogbo'],


            'Oyo' => ['Afijio', 'Akinyele', 'Atiba', 'Atisbo', 'Egbeda', 'Ibadan North', 'Ibadan North-East', 'Ibadan North-West', 'Ibadan South-East', 'Ibadan South-West', 'Ibarapa Central', 'Ibarapa East', 'Ibarapa North', 'Ido', 'Irepo', 'Iseyin', 'Itesiwaju', 'Iwajowa', 'Kajola', 'Lagelu', 'Ogbomosho North', 'Ogbomosho South', 'Ogo Oluwa', 'Olorunsogo', 'Oluyole', 'Ona Ara', 'Orelope', 'Ori Ire', 'Oyo East', 'Oyo West', 'Saki East', 'Saki West', 'Surulere'],

            'Plateau' => ['Barkin Ladi', 'Bassa', 'Bokkos', 'Jos East', 'Jos North', 'Jos South', 'Kanam', 'Kanke', 'Langtang North', 'Langtang South', 'Mangu', 'Mikang', 'Pankshin', 'Qua’an Pan', 'Riyom', 'Shendam', 'Wase'],

            'Rivers' => ['Abua/Odual', 'Ahoada East', 'Ahoada West', 'Akuku-Toru', 'Andoni', 'Asari-Toru', 'Bonny', 'Degema', 'Emohua', 'Eleme', 'Etche', 'Gokana', 'Ikwerre', 'Khana', 'Obio/Akpor', 'Ogba/Egbema/Ndoni', 'Ogu/Bolo', 'Okrika', 'Omuma', 'Opobo/Nkoro', 'Oyigbo', 'Port Harcourt', 'Tai'],

            'Sokoto' => ['Binji', 'Bodinga', 'Dange Shuni', 'Gada', 'Goronyo', 'Gudu', 'Gwadabawa', 'Illela', 'Isa', 'Kebbe', 'Kware', 'Rabah', 'Sabon Birni', 'Shagari', 'Silame', 'Sokoto North', 'Sokoto South', 'Tambuwal', 'Tangaza', 'Tureta', 'Wamako', 'Wurno', 'Yabo'],

            'Taraba' => ['Ardo Kola', 'Bali', 'Donga', 'Gashaka', 'Gassol', 'Ibi', 'Jalingo', 'Karim Lamido', 'Kumi', 'Lau', 'Sardauna', 'Takum', 'Ussa', 'Wukari', 'Yorro', 'Zing'],

            'Yobe' => ['Bade', 'Bursari', 'Damaturu', 'Fika', 'Fune', 'Geidam', 'Gujba', 'Gulani', 'Jakusko', 'Karasuwa', 'Machina', 'Nangere', 'Nguru', 'Potiskum', 'Tarmuwa', 'Yunusari', 'Yusufari'],

            'Zamfara' => ['Anka', 'Bakura', 'Birnin Magaji/Kiyaw', 'Bukkuyum', 'Bungudu', 'Gummi', 'Gusau', 'Kaura Namoda', 'Maradun', 'Maru', 'Shinkafi', 'Talata Mafara', 'Tsafe', 'Zurmi'],



        ];

        return $localGovernments[$state] ?? [];
    }


    public function countrySelected()
    {
        if ($this->country === 'Nigeria') {
            $this->states = $this->getNigerianStates();
            $this->localGovernments = [];
        } else {
            $this->states = [];
            $this->localGovernments = [];
        }
    }


    public function stateSelected()
    {
        // Logic to handle state selection
        if (!empty($this->state)) {
            // Load local governments for the selected state
            $this->localGovernments = $this->getLocalGovernmentsByState($this->state);
        } else {
            // Clear local governments if no state is selected
            $this->localGovernments = [];
        }
    }


    // format our subject for oleve exam sitting
    protected function formatSubjects($subjects)
    {
        $formattedSubjects = [];

        foreach ($subjects as $subject) {
            $formattedSubjects[] = [
                'subject' => $subject['subject'],
                'score' => $subject['score'],
            ];
        }

        return $formattedSubjects;
    }

    // prepare for media file submittion
    protected function storeFile($file, $directory)
    {
        if ($file) {
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($directory, $filename);
            return $path;
        }

        return null;
    }


    // here we finally submit the form
    public function register()
    {
        $this->resetErrorBag();

        if ($this->currentStep == 5) {
            $this->validate([
                'document_medical_report' => 'file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
                'document_birth_certificate' => 'file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
                'document_local_government_identification' => 'file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
                'document_secondary_school_certificate_type' => 'file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
                'passport_photo' => 'image|mimes:jpeg,jpg,png|max:2048', // Max 2MB, only image files
                'terms' => 'accepted'
            ]);
        }

        // Store files with unique filenames
        $documentMedicalReportPath = $this->storeFile($this->document_medical_report, 'public/documents');
        $documentBirthCertificatePath = $this->storeFile($this->document_birth_certificate, 'public/documents');
        $documentLocalGovIdPath = $this->storeFile($this->document_local_government_identification, 'public/documents');
        $documentSecondarySchoolCertPath = $this->storeFile($this->document_secondary_school_certificate_type, 'public/documents');
        $passportPhotoPath = $this->storeFile($this->passport_photo, 'public/photos');

        // Create a new array with the file paths
        $files = [
            'document_medical_report' => $documentMedicalReportPath,
            'document_birth_certificate' => $documentBirthCertificatePath,
            'document_local_government_identification' => $documentLocalGovIdPath,
            'document_secondary_school_certificate_type' => $documentSecondarySchoolCertPath,
            'passport_photo' => $passportPhotoPath,
        ];

        // In the register method
        $olevelExams = [
            'sittings' => $this->sittings,
            'exam_boards' => [
                'exam_board_1' => $this->examBoard1,
                'exam_board_2' => $this->examBoard2,
            ],
            'subjects' => [
                'sitting_1' => $this->formatSubjects($this->subjects1),
                'sitting_2' => $this->formatSubjects($this->subjects2),
            ],
        ];

        // Convert to JSON and save to database
        $olevelExamsJson = json_encode($olevelExams);

        $user = User::where('id', $this->userId)->firstOrFail();
        $userData = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'other_names' => $this->other_names,
            'email' => $this->email,
        ];
        $user->update($userData);



        if ($user->student) {
            $user->student->update([
                'application_unique_number' => $this->generateUniqueNumber(),
                'document_medical_report' => $documentMedicalReportPath,
                'document_birth_certificate' => $documentBirthCertificatePath,
                'document_local_government_identification' => $documentLocalGovIdPath,
                'document_secondary_school_certificate_type' => $documentSecondarySchoolCertPath,
                'passport_photo' => $passportPhotoPath,
                'phone' => $this->phone,
                'gender' => $this->gender,
                'dob' => $this->dob,
                'religion' => $this->religion,
                'nin' => $this->nin,
                'country_of_origin' => $this->country,
                'nationality' => $this->country,
                'state_of_origin' => $this->state,
                'lga_origin' => $this->localGovernment,
                'current_residence_address' => $this->current_residence_address,
                'permanent_residence_address' => $this->permanent_residence_address,
                'guardian_name' => $this->guardian_name,
                'guardian_phone_number' => $this->guardian_phone_number,
                'guardian_address' => $this->guardian_address,
                'secondary_school_attended' => $this->secondary_school_attended,
                'secondary_school_graduation_year' => $this->secondary_school_graduation_year,
                'secondary_school_certificate_type' => $this->secondary_school_certificate_type,
                'jamb_reg_no' => $this->jamb_reg_no,
                'jamb_score' => $this->jamb_score,
                'olevel_exams' => $olevelExamsJson,
                'blood_group' => $this->blood_group,
                'genotype' => $this->genotype
            ]);
        }




        $application = Application::updateOrCreate(
            [
                'user_id' => $this->userId,
                'department_id' => $this->department_id,
                'invoice_number' => mt_rand(100000, 999999)
            ]
        );


        // Dispatch the job
        // ProcessRegistration::dispatch($userData, $applicationData, $studentData, $files);

        Mail::to($user->email)->send(new RegistrationConfirmationMail($user, $application));



        $notification = [
            'message' => 'Application Details submitted, proceed to payment to finalize the process, thank you',
            'alert-type' => 'success',
        ];
        return redirect()->route('payment.view.finalStep', ['userSlug' => $user->nameSlug, 'application' => $application])->with($notification);
    }


    private function generateUniqueNumber()
    {
        $lastRegisteredPerson = Student::max('id') + 1;
        return 'SHN' . mt_rand(1000000, 9999999) . $lastRegisteredPerson;
    }
}
