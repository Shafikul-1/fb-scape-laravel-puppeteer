//     $nodeExec = 'node';
        // $scriptPath = base_path('resources/js/index.js');

        // // Additional arguments to pass to the Node.js script
        // $arg1 = 'arg1_value';
        // $arg2 = 'arg2_value';

        // // Create the command string
        // $command = "$nodeExec $scriptPath " . escapeshellarg($arg1) . " " . escapeshellarg($arg2);

        // exec($command, $output, $returnVar);

        // Log::info('Node.js Output: ' . print_r($output, true));
        // Log::info('Return Var: ' . $returnVar);

        // return response()->json([
        //     'output' => $output,
        //     'return_var' => $returnVar,
        // ]);

        const args = process.argv.slice(2);
console.log('Arguments:', args);








//node fs pass json data

public function index(Request $request)
    {
        $nodeExec = 'node';
        $scriptPath = base_path('resources/js/index.js');

        // JSON ডেটা প্রস্তুত করা
        $data = ['key1' => 'value1', 'key2' => 'value2'];
        $jsonData = json_encode($data);

        Log::info('Raw JSON Data: ' . $jsonData);

        // Command তৈরি করা
        $command = "$nodeExec $scriptPath \"$jsonData\"";

        Log::info('Command: ' . $command);
        exec($command, $output, $returnVar);

        Log::info('Node.js Output: ' . print_r($output, true));
        Log::info('Return Var: ' . $returnVar);

        return response()->json([
            'output' => json_decode(implode("", $output), true),
            'return_var' => $returnVar,
        ]);
    }











    'pameladunnparrishphotographer',
    'popofpurephotography',
    'AquariusDreamscapesPhotography',
    'kwdesignsphotography',
    'profile.php?id=100084885063354',
    'mephotodesign',
    'PhotographbyChris',
    'NicholeMCHPhotography',
    'GenPalmerPhotography',
    'photographyddianaphilly',
    'junebugsmemories',
    'KtLizPhotography',
    'katiekayphotography',
    'kaylasphotographypitman',
    'photosbykh',
    'intriguephotographycompany',
    'oliviaannephotography',
    'jennycastrophotography',
    'MCMPHOTO',
    'profile.php?id=100064236153182',
    'azzphoto',
    'margaretkoningphotography',
    'larkbuntingphotography',
    'Jessicadelphoto',
    'forrestseuserphotography',
    'ThroughTheLookingGlass19',
    'brynmarae.photography',
    'itsasmallworldphotography',
    'NoelPhotographytx',
    'Bluegillphotography',
    'margaretkoningphotography',
    'MegBowmanPhotography',
    'Jessicadelphoto',
    'ashleymckeephotography',
    'kwdesignsphotography',
    'BritniGirardPhoto',
    'spokenforphotography',
    'mackenziestevensonphotography',
    'nikibryantpics',
    'brandypacephotography',
    'ValerieKayPhoto',
    'crimsoncloverstudios',
    'kaykroshus',
    'sweetsunshinephotographyllc',
    'BridgetteWilliamsPhotography',
    'chirpydphotography',
    'simplyphotographyco',
    'heatherrichardsonphotographer',
    'MaiShuPhotography',
    'simplyphotographyco',
    'heatherrichardsonphotographer',
    'MaiShuPhotography'
