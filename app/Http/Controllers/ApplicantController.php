<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Job;
use App\Mail\SampleMail;
use Illuminate\Support\Facades\Mail;

class ApplicantController extends Controller
{
    // CREATE
    public function createApplicant(Request $request)
    {

        // if(isset($_POST["btn_save"]))
        // {
        //     // Statements to execute when save button is clicked.
        //     return back()->with('message', 'You clicked save button.')->with('status', 'danger');
        // }

        // if(isset($_POST["btn_add"]))
        // {
        //     // Statements to execute when add button is clicked.
        //     return back()->with('message', 'You clicked add button.')->with('status', 'success');
        // }

        // Validate request data
        try {
            $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'address' => 'required',
                'email' => ['required','email','unique:applicants','regex:/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'],
            ]);
            
            // Create record using Eloquent ORM
            $applicant = Applicant::create([
                'first_name' => $request->firstname,
                'last_name' => $request->lastname,
                'address' => $request->address,
                'email' => $request->email,
            ]);

            return back()->with('message', 'Applicant added successfully.')->with('status', 'success');
           
        } catch (\Exception $e) {
            return back()->with('message', $e->getMessage())->with('status', 'danger');
        }
    }

    // READ
    public function getApplicants()
    {
        $data = Applicant::all();  // SELECT * FROM applicant
        return view('applicationform', ['data' => $data]);
    }

    // UPDATE
    public function updateApplicant(Request $request, string $applicant_id)
    {
        try {
            // Validate request data
            $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'address' => 'required',
                'email' => ['required','email','regex:/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'],
            ]);

            // Update record using Eloquent ORM
            $applicant=Applicant::find($applicant_id);  // SELECT * FROM applicant WHERE id=$applicant_id
            $applicant->first_name = $request->firstname;
            $applicant->last_name = $request->lastname;
            $applicant->address = $request->address;
            $applicant->email = $request->email;
            $applicant->save();

            return back()->with('message', 'Details edited successfully.')->with('status', 'success');

        } catch (\Exception $e) {
            return back()->with('message', $e->getMessage())->with('status', 'danger');
        }
    }

    // DELETE
    public function deleteApplicant(string $applicant_id)
    {
        try {
            // Delete record using Eloquent ORM
            Applicant::destroy($applicant_id);  // DELETE FROM applicant WHERE id=$applicant_id

            return back()->with('message', 'Applicant removed successfully.')->with('status', 'success');

        } catch (\Exception $e) {
            return back()->with('message', $e->getMessage())->with('status', 'danger');
        }
    }


    

    // READ
    public function displaytable_admin()
    {
        $data = Job::all();  // SELECT * FROM job
        return view('table', ['data' => $data]);
    }

    public function update_jobstatus(string $job_id)
    {
        $data = Job::find($job_id);
        
        // if open ang status, ico-close
        // if close, io-open
        if($data->status == "open")
        {
            // update status to close
            $data->status = "close";
        }
        else
        {
            // update status to open
            $data->status = "open";
        }
        $data->save();


        Mail::to('zurbanonicamae.m.09@gmail.com')->send(new SampleMail());

        return back();
    }

    public function display_posted_jobs()
    {
        $data = Job::where("status","open")->get();
        return view('postedjobs', ['data' => $data]);
    }

    public function search_job(Request $request)
    {
        // $request->validate([
        //     'category' => 'required',
        //     'location' => 'required',
        //     'keyword' => 'required',
        // ]);
        // $data = Job::where("category",$request->category)
        //             ->where("location",$request->location)
        //             ->where("name","like","%".$request->keyword."%")
        //             ->where("status","open")
        //             ->get();
        $category = $request->category;
        $location = "$request->location";
        $keyword = $request->keyword;
        if($category == null)
        {
            if($location == null)
            {
                if($keyword == null)
                {
                    // category = null
                    // location = null
                    // keyword = null
                    $data = Job::where(function ($query) use ($category, $location, $keyword)  {
                        $query->where("category",$category)
                            ->orWhere("location",$location)
                            ->orWhere("name","like","%".$keyword."%");
                    })->where("status","open")->get();
                }
                else
                {
                    // category = null
                    // location = null
                    // keyword = not null
                    $data = Job::where(function ($query) use ($category, $location, $keyword)  {
                        $query->where("name","like","%".$keyword."%");
                    })->where("status","open")->get();
                }
            }
            elseif($keyword == null)
            {
                // category = null
                // location = not null
                // keyword = null
                $data = Job::where(function ($query) use ($category, $location, $keyword)  {
                    $query->where("location",$location);
                })->where("status","open")->get();
            }
            else
            {
                // category = null
                // location = not null
                // keyword = not null
                $data = Job::where(function ($query) use ($category, $location, $keyword)  {
                    $query->where("location",$location)
                        ->orWhere("name","like","%".$keyword."%");
                })->where("status","open")->get();
            }
        }
        elseif($location == null)
        {
            if($keyword == null)
            {
                // category = not null
                // location = null
                // keyword = null
                $data = Job::where(function ($query) use ($category, $location, $keyword)  {
                    $query->where("category",$category);
                })->where("status","open")->get();
            }
            else
            {
                // category = not null
                // location = null
                // keyword = not null
                $data = Job::where(function ($query) use ($category, $location, $keyword)  {
                    $query->where("category",$category)
                        ->orWhere("name","like","%".$keyword."%");
                })->where("status","open")->get();
            }
        }
        elseif($keyword == null)
        {
            // category = not null
            // location = not null
            // keyword = null
            $data = Job::where(function ($query) use ($category, $location, $keyword)  {
                $query->where("category",$category)
                    ->orWhere("location",$location);
            })->where("status","open")->get();
        }

        // return $data;
        // return view('searchjob', ['data' => $data]);
        return back()->with('data',$data);
    }

    public function display_toggle_button()
    {
        $data = Job::where("status","open")->get();
        return view('toggle-button', ['data' => $data]);
    }
}
