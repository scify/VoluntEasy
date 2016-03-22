<p><strong>Πώς έμαθε για εμάς:</strong> {{ $volunteer->howYouLearned==null || $volunteer->howYouLearned=='' ? '-' : $volunteer->howYouLearned->description}}</p>
<p><strong>Πώς ενημερώθηκε για τη θέση εργασίας εθελοντισμού:</strong>  {{ $volunteer->howYouLearned2==null || $volunteer->howYouLearned2=='' ?  '-' : $volunteer->howYouLearned2->description}}</p>
