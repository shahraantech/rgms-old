

     
     
<nav class=" navbar-expand-lg">
 
        <?php
     
            $overAllRatings=0;
            $count_rows=0;
          
            $r=DB::select("SELECT rating FROM ratings ");
            if($r){
             $count_rows = count($r);
            $count_row=$count_rows;
            $sum=0;
            foreach($r as $r){
            $rate= $r->rating;
            $sum=$sum+$rate;
                                 
                    }
                $overAllRatings=($sum/$count_row);
                                 
                                    }
                                    
                                    ?> 

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
       
      
        <div class="placeholder" style="color: orange;">
            <i class="far fa-star" style="color:"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
            <span class="small">({{ $count_rows }})</span>
        </div>

        <div class="overlay" style="position: relative;top: -17px; color:orange">
            
            @while($overAllRatings>0)
                @if($overAllRatings >0.5)
                    <i class="fas fa-star"></i>
                @else
                    <i class="fas fa-star-half"></i>
                @endif
                @php $overAllRatings--; @endphp
            @endwhile

        </div> 
        </li>
      </ul>
        
        
       

    </div>
</nav>
        
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
