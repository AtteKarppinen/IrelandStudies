% some example rules to get you started


% rule 1
stimulus_situation(verbal) :-           environment(papers);
                                        environment(manuals);
                                        environment(documents);
                                        environment(textbooks).

% rule 2
stimulus_situation(visual) :-           environment(pictures);
                                        environment(illustrations);
                                        environment(photographs);
                                        environment(diagrams).

% rule 3
stimulus_situation(physical_object) :-  environment(machines);
                                        environment(buildings);
                                        environment(tools).

% rule 4
stimulus_situation(symbolic) :-         environment(numbers);
                                        environment(formulas);
                                        environment(computer_programs).

% rule imaginary situation
stimulus_situation(imaginary) :-        environment(drugs);
                                        environment(dream).

% rule non-existent response
stimulus_response(non_existent) :-  job(addict);
                                    job(jobless).

% rule 5
stimulus_response(oral) :-          job(lecturing);
                                    job(advising);
                                    job(counselling).

% rule 6
stimulus_response(hands-on) :-      job(building);
                                    job(repairing);
                                    job(troubleshooting).

% rule 7
stimulus_response(documented) :-    job(writing);
                                    job(typing);
                                    job(drawing).

% rule 8
stimulus_response(analytical) :-    job(evaluating);
                                    job(reasoning);
                                    job(investigating).

% rule 9
medium(workshop) :-             stimulus_situation(physical_object),
                                stimulus_response(hands_on),
                                feedback(yes).

% rule 10
medium(lecture-tutorial) :-     stimulus_situation(symbolic),
                                stimulus_response(analytical),
                                feedback(yes).

% rule 11
medium(videocasette) :-         stimulus_situation(visual),
                                stimulus_response(documented),
                                feedback(no).

% rule 12
medium(lecture-tutorial) :-     stimulus_situation(visual),
                                stimulus_response(oral),
                                feedback(yes).

% rule 13
medium(lecture-tutorial) :-     stimulus_situation(verbal),
                                stimulus_response(analytical),
                                feedback(yes).

% rule 14
medium(role-play_exercises) :-  stimulus_situation(verbal),
                                stimulus_response(oral),
                                feedback(yes).

% rule wake up call
medium(wake-up-call) :-         stimulus_situation(imaginary),
                                stimulus_response(non_existent),
                                feedback(yes).


% 3 inputs required: 1 environment 2 job, 3 feedback yes/no

go :-
    getEnvironment,
    getJob,
    feedback,
    ( stimulus_situation(SS),
      nl, write('Stimulus situation is '), write(SS),
      stimulus_response(SR),
      nl, write('Stimulus response is '), write(SR),
      medium(M),
      nl, write('Medium is '), write(M), nl
    ;
      writeln('Could not advise on an appropriate medium')
    ),
    cleanInputs.

getEnvironment :-
    write('Input the environment '),
    read(E),
    assert(environment(E)).

getJob :-
    write('Input the job'),
    read(F),
    assert(job(F)).

feedback :-
    write('Is feedback required yes/no '),
    read(G),
    assert(feedback(G)).

cleanInputs :-
    retractall(environment(_)),
    retractall(job(_)),
    retractall(feedback(_)).
