<p><strong>Πώς έμαθε για εμάς:</strong> {{ $volunteer->howYouLearned==null || $volunteer->howYouLearned=='' ? '-' : $volunteer->howYouLearned}}</p>
<p><strong>Πώς ενημερώθηκε για τη θέση εργασίας εθελοντισμού:</strong>  {{ $volunteer->extras!=null && ($volunteer->extras->howYouLearned2==null || $volunteer->extras->howYouLearned2=='') ? $volunteer->extras->howYouLearned2 : '-' }}</p>
