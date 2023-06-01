<?php date_default_timezone_set('America/Los_Angeles');  ?>
<div class="container" id="body">
    <p id="message"
        class="small p-0 m-0 text-light error_message position-fixed top-0 rounded-start end-0 p-1"
        style="display: none"></p>
    <div id="prealoader">
        <div class="prealoader d-flex justify-content-center align-items-center position-absolute">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>


    <div class="row row-eq-height">
        <!-- //hours details -->
        <div class="col-md-12 col-lg-4 col-xl-4 shadow-sm px-4 bg-body rounded d-flex flex-column">
            <form id="calculator" target="_blank" method="post" action="<?php echo plugin_dir_url(__FILE__); ?>../pdf/"
                accept-charset="utf-8" enctype="multipart/form-data">
                <div>
                    <label for="name" class="form-label">Employee Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" placeholder="Employee Name" class="form-control" value="" required>
                    <p id="name_error" class="small p-0 m-0 text-danger"></p>
                </div>
                <div>
                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                    <input type="date" name="start_date" id="start_date" placeholder="Start Date" class="form-control"
                        required>
                    <p id="start_date_error" class="small p-0 m-0 text-danger"></p>
                </div>
                <div>
                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                    <input type="date" name="end_date" id="end_date" placeholder="End Date" class="form-control"
                        required>
                    <p id="end_date_error" class="small p-0 m-0 text-danger"></p>
                </div>
                <div>
                    <label for="avg_hours" class="form-label">Average hours scheduled per week <span
                            class="text-danger">*</span> </label>
                    <input type="number" name="avg_hours" id="avg_hours" placeholder="prior to the start of FMLA"
                        value="40" class="form-control" min="0">
                    <p id="avg_hour_error" class="small p-0 m-0 text-danger"></p>
                </div>
                <div class="mb-2">
                <div for="" class="form-label">Types of leave <span
                    class="text-danger">*</span></div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="Continuous" value='continuous' required>
                    <label class="form-check-label" for="Continuous">
                        Continuous
                    </label>
                </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="Intermittent" value="intermittent" required>
                    <label class="form-check-label" for="Intermittent">
                        Intermittent
                    </label>
                    </div>
                </div>
        </div>

        <!-- Total hours -->
        <div class="col-md-12 col-lg-4 col-xl-4">
            <div class="card mx-2 bg-body shadow-sm rounded h-100">
                <div class="text-center">
                    <h5 class="card-header">Total Hours</h5>
                    <div class="card-body">
                        <input type="hidden" id="used_hidden" name="used" value="">
                        <h2 class="fs-1" id="fmla_used">0</h2>
                        <p class="card-text">FMLA Hours Used</p>
                    </div>
                    <hr>
                    <div class="card-body">
                        <h2 class="fs-1" id="available">480</h2>
                        <p class="card-text"> FMLA Hours Available </p>
                    </div>
                </div>
                <small style="font-size: 13px;" class="mt-4">
                    <b class="px-2 pt-2">Instructions:</b>
                    <ol>
                        <li>Fields marked with <span class="text-danger">*</span> are required.</li>
                        <li>Please enter your name, dates, average working hours and choose FMLA leave type to get started.</li>
                    </ol>
                </small>
            </div>
        </div>
        <!-- //Chart -->
        <div class="col-md-12 col-lg-4 col-xl-4 shadow-sm p-0 bg-body rounded">
            <div id="fmlachart" style=" width: auto;height: 350px;"></div>
            <input type="hidden" id="chart" name="chart">
        </div>
    </div>
    <!-- //sub Total -->
    <div class="row shadow-sm mt-4 bg-body rounded table-responsive text-center">
        <div class="month col-md-12 col-lg-3 col-xl-3 text-center">
            <div class="bg-gradient-danger card shadow-sm m-2 bg-body rounded">
                <h5 class="card-header">January</h5>
                <div class="card-body">
                    <table id="1">
                        <thead>
                        <tr>  
                        <th>S</th>                         
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>T</th>
                            <th>F</th>
                            <th>S</th>
                          
                        </tr>
                    </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="month col-md-12 col-lg-3 col-xl-3 text-center">
            <div class="bg-gradient-danger card shadow-sm m-2 bg-body rounded">
                <h5 class="card-header">February</h5>
                <div class="card-body">
                <table id="2">
                        <thead>
                        <tr>  
                            <th>S</th>                         
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>T</th>
                            <th>F</th>
                            <th>S</th>                            
                        </tr>
                    </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="month col-md-12 col-lg-3 col-xl-3 text-center">
            <div class="bg-gradient-danger card shadow-sm m-2 bg-body rounded">
                <h5 class="card-header">March</h5>
                <div class="card-body">
                <table id="3">
                        <thead>
                        <tr> 
                            <th>S</th>                          
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>T</th>
                            <th>F</th>
                            <th>S</th>
                        </tr>
                    </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="month col-md-12 col-lg-3 col-xl-3 text-center">
            <div class="bg-gradient-danger card shadow-sm m-2 bg-body rounded">
                <h5 class="card-header">April</h5>
                <div class="card-body">
                <table id="4">
                        <thead>
                        <tr>  
                        <th>S</th>                         
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>T</th>
                            <th>F</th>
                            <th>S</th>                           
                        </tr>
                    </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="month col-md-12 col-lg-3 col-xl-3 text-center">
            <div class="bg-gradient-danger card shadow-sm m-2 bg-body rounded">
                <h5 class="card-header">May</h5>
                <div class="card-body">
                <table id="5">
                        <thead>
                        <tr> 
                        <th>S</th>                          
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>T</th>
                            <th>F</th>
                            <th>S</th>
                           
                        </tr>
                    </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="month col-md-12 col-lg-3 col-xl-3 text-center">
            <div class="bg-gradient-danger card shadow-sm m-2 bg-body rounded">
                <h5 class="card-header">Jun</h5>
                <div class="card-body">
                <table id="6">
                        <thead>
                        <tr>    
                        <th>S</th>                       
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>T</th>
                            <th>F</th>
                            <th>S</th>
                           
                        </tr>
                    </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="month col-md-12 col-lg-3 col-xl-3 text-center">
            <div class="bg-gradient-danger card shadow-sm m-2 bg-body rounded">
                <h5 class="card-header">July</h5>
                <div class="card-body">
                <table id="7">
                        <thead>
                        <tr> 
                        <th>S</th>                          
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>T</th>
                            <th>F</th>
                            <th>S</th>
                            
                        </tr>
                    </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="month col-md-12 col-lg-3 col-xl-3 text-center">
            <div class="bg-gradient-danger card shadow-sm m-2 bg-body rounded">
                <h5 class="card-header">August</h5>
                <div class="card-body">
                <table id="8">
                        <thead>
                        <tr>  
                        <th>S</th>                         
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>T</th>
                            <th>F</th>
                            <th>S</th>
                           
                        </tr>
                    </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="month col-md-12 col-lg-3 col-xl-3 text-center">
            <div class="bg-gradient-danger card shadow-sm m-2 bg-body rounded">
                <h5 class="card-header">September</h5>
                <div class="card-body">
                <table id="9">
                        <thead>
                        <tr>  
                        <th>S</th>                         
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>T</th>
                            <th>F</th>
                            <th>S</th>
                           
                        </tr>
                    </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="month col-md-12 col-lg-3 col-xl-3 text-center">
            <div class="bg-gradient-danger card shadow-sm m-2 bg-body rounded">
                <h5 class="card-header">October</h5>
                <div class="card-body">
                <table id="10">
                        <thead>
                        <tr>   
                        <th>S</th>                        
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>T</th>
                            <th>F</th>
                            <th>S</th>
                            
                    </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="month col-md-12 col-lg-3 col-xl-3 text-center">
            <div class="bg-gradient-danger card shadow-sm m-2 bg-body rounded">
                <h5 class="card-header">November</h5>
                <div class="card-body">
                <table id="11">
                        <thead>
                        <tr>    
                        <th>S</th>                       
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>T</th>
                            <th>F</th>
                            <th>S</th>
                           
                        </tr>
                    </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="month col-md-12 col-lg-3 col-xl-3 text-center">
            <div class="bg-gradient-danger card shadow-sm m-2 bg-body rounded">
                <h5 class="card-header">December</h5>
                <div class="card-body">
                <table id="12">
                        <thead>
                        <tr>   
                        <th>S</th>                        
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>T</th>
                            <th>F</th>
                            <th>S</th>                           
                        </tr>
                    </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <input type="hidden" name="each_month_total" id="each_month_total">
    </div>
    <button class="btn btn-primary mt-3 float-end" disabled type="button" id="popup" data-bs-toggle="modal" data-bs-target="#exampleModal"><svg
            xmlns="http://www.w3.org/2000/svg" width="20" height="16" fill="currentColor" class="bi bi-file-pdf"
            viewBox="0 0 16 16">
            <path
                d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
            <path
                d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.701 19.701 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.187-.012.395-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95 11.642 11.642 0 0 0-1.997.406 11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193 11.666 11.666 0 0 1-.51-.858 20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z" />
    
        </svg> Export PDF</button>        
        <div class="popup modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Just one last step</h5>                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>Please fill your details to download the report</p>
                    <div>
                        <label for="email" class="form-label">Business Email<span class="text-danger"> *</span></label>
                        <input type="email" name="email" id="email" class="form-control" value="" pattern="(^[a-zA-Z0-9.%+-]+@(?!gmail.com)(?!yahoo.com)(?!hotmail.com)(?!yahoo.co.in)(?!aol.com)(?!live.com)(?!outlook.com)[a-zA-Z0-9-]+.[a-zA-Z0-9-.]{2,61}$)" required>
                        <p id="email_error" class="small p-0 m-0 text-danger"></p>
                    </div>
                    <div>
                        <label for="phone" class="form-label">Phone<span class="text-danger"> *</span></label>
                        <input type="tel" name="phone" id="phone" class="form-control" value="" required pattern="^[1-9]\d{2}-\d{3}-\d{4}">
                        <p id="phone_error" class="small p-0 m-0 text-danger"></p>
                    </div>
                    <div>
                        <label for="companyname" class="form-label">Company name<span class="text-danger"> *</span></label>
                        <input type="text" name="companyname" id="companyname" required class="form-control" value="">
                        <p id="company_error" class="small p-0 m-0 text-danger"></p>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-center">                      
                          <button class="btn btn-primary mt-3" type="submit" id="submit">GET A REPORT</button>                       
                  </div>
                </div>
              </div>
        </div>
    </form>
</div>