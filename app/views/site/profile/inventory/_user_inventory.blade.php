<!--This is the contents of Inventory page-->
<div class="search_box search">
  <form class="navbar-form navbar-left" role="search">
    <div class="form-group">
      <input type="text" class="form-control" placeholder=" search inventory ">
    </div>
    <button type="submit" class="btn btn-search "> <i class="fa fa-search"></i></button>
  </form>
</div> 
<br>
<div style="position: relative">
  <p>You have borrowed {{count($transactions)}} items. 
    
    <!-- Count the items that are overdued -->
    @foreach($transactions as $transaction)
      @if($today > $transaction->due_date)
      <?php $dueitemcount = $dueitemcount + 1 ?>
      @endif
    @endforeach
    
    <!-- Echo the number of items + message -->
    @if($dueitemcount > 0)
      <span style = "color: red">{{$dueitemcount}}</span> 
      
      <!-- is or are? -->
      @if($dueitemcount > 1)
      are 
      @else
      is 
      @endif
      
      <span style = "color: red">overdue</span>. </p>
    @else

    @endif
</div>
 <!--This is the inventory table of Inventory page-->
<div class="item_table table-responsive">
    <table class="table">
      <thead>
          <tr>
              <th>BORROWED ON</th>
              <th>ITEM</th>
              <th>QUANTITY</th>
              <th>DUE DATE</th>
          </tr>
      </thead>
         
          <tbody>
         
          @foreach($transactions as $transaction)
              <?php $i = $i++ ?> 
              <tr>
                  <td>
                      {{ $transaction->created_at }}
                  </td>
                  <td>
                      {{ $items[$i]->name }}
                  </td>
                  <td>
                      {{ $transaction->quantity }}
                  </td>
                  <td>
                      {{ $transaction->due_date }}
                  </td>
              </tr>
          @endforeach
      </tbody>
    </table>

</div>