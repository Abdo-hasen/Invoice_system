<?php

/*

//make custom request - validations :
##############
php artisan make:request Product#/StoreProduct#Request

#######################################################

//edit in migrate or migration file
#############
php artisan mi:f --seed

#######################################################
database files : model - migration
#############
php artisan make:model Invoice# -m

#######################################################

//validation rules :
            'number' => 'required|string|min:3', 
            'invoices_date' => 'required|date',
            'due_date' => 'required|date',
            'product' => 'required|string',
            'section_id' => 'required|exists:sections,id',
            'amount_collection' => 'nullable|numeric',
            'amount_commission' => 'required|numeric',
            'discount' => 'numeric',
            'rate_vat' => 'required|string',
            'value_vat' => 'numeric',
            'total' => 'numeric',
            'note' => 'nullable|string',
            'payment_date' => 'nullable|date',


"description" => "required|string|min:3|max:225|regex:/^[a-zA-Z0-9\s]+$/",
"price" => "required|numeric",
"category_id" => "required|exists:categories,id",

//store:
"name" => "required|string|min:3|max:225|unique:products,name",
"image" => "required|image|mimes:png,jpg,jpeg|max:2048"

update:
"name" => "required|string|min:3|max:225|unique:products,name," . $this->product->id,
"image" => "nullable|image|mimes:png,jpg,jpeg|max:2048",

#######################################################

// check error in create : 
#####################
     @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

 ##############################################
 //store or create in db or by eloquent
 
 Invoice#::create([
     "name#" => $request->name# ,
    ]);
    ##############################################
    filetarit - upload file image - delete image - update image
    #############

    trait FileTrait
{
    private function uploadImage($path, $image, $old_image = null)
    {
        if($old_image)
        {
            $this->deleteImage($path, $old_image);
        }

        $image_name = uuid_create() . "_" . $image->getClientOriginalName();
        $image->move($path, $image_name);
        return $image_name;
    }

    private function deleteImage($path, $old_image)
    {
       $image_path = public_path($path . $old_image);

        if(file_exists($image_path))
        {
            unlink($image_path);
        }

    }

###################################################################
    fillable
    ############

    protected $fillable = [
        "name#",
    ];
    
#################################################
index loop - read display items - foreach
############################

                @foreach ($invoices# as $invoice  )                                    
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $invoice->name#}}</td>
                    <td>{{ $invoice->section->name#}}</td>//relation
            
                </tr>
                @endforeach

#########################################
redirect view - logic
#########

    logic
    #######
    return $this->redirect("Invoice Has Been Created Successfully#", "admin.invoices.index#");

    view
    #####
            return view("Admin.pages.invoices.index#",compact("invoices"#));


####################################################
one to many relationship in database - laravel - controller
#########################
db - migration: 
######
  $table->foreignId("section_id#")->constrained("sections#")->onDelete("cascade");

laravel :
########
write what u say : 
1 section has many invoices 
invoices belongs to one section

  public function invoices#()
    {
        return $this->hasMany(Invoice#::class);
    }

      public function section#()
    {
        return $this->belongsTo(Section#::class);
    }

    controller 
    ########
        $invoices = Invoice::with("section")->paginate();

###############################################
last id inserted in database
###############

        $invoice_id = Invoice::latest()->first()->id;

###########################################
current_user
########

 auth()->user()->name

###########################################
status color 
#########

 <td>
    @if ($invoice->value_status == 1)
        <span class="text-success">{{ $invoice->status }}</span>
    @elseif($invoice->value_status == 2)
        <span class="text-danger">{{ $invoice->status }}</span>
    @else
        <span class="text-warning">{{ $invoice->status }}</span>
    @endif
</td>

##############################################
show - url - details
######
<td><a href="{{ url("admin/invoices/show/") . "/" . $invoice->id }}">{{ $invoice->section->name }}</a></td>

##############################################
تاريخ يوم بارقام 
###################

value="{{ date("Y-m-d") }}"

##########################################################################
@selected - section foreach - select menu
################

   <div class="col">
                                    <label>Section</label>
                                    <select class="form-control" name="section_id">
                                        <option value="">Select Section</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}" @selected($section->id == $invoice->section_id)>{{ $section->name }}>{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
##########################################################################



 */


